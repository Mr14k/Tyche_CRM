<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\TenantContext;
use App\Models\JobPosting;
use App\Models\JobApplication;
use App\Models\Resume;
use App\Core\Database;

class PlacementService extends Service
{
    public function applyForJob(int $jobId, int $userId, ?string $coverNote = null): array
    {
        $tid = TenantContext::getTenantId();
        $existing = Database::fetchOne("SELECT * FROM job_applications WHERE job_id = :job_id AND user_id = :user_id AND tenant_id = :tid", [
            'job_id' => $jobId,
            'user_id' => $userId,
            'tid' => $tid
        ]);

        if ($existing) {
            return ['application_id' => (int)$existing['id'], 'status' => $existing['status']];
        }

        $appModel = new JobApplication();
        $appId = $appModel->create([
            'job_id' => $jobId,
            'user_id' => $userId,
            'status' => 'applied',
            'cover_note' => $coverNote
        ]);

        return ['application_id' => (int)$appId, 'status' => 'applied'];
    }
}
