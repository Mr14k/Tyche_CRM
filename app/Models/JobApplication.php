<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use App\Core\TenantContext;

class JobApplication extends Model
{
    protected string $table = 'job_applications';

    public function getApplicationsWithDetails(): array
    {
        $tid = TenantContext::getTenantId();
        $sql = "SELECT a.*, j.title as job_title, e.company_name, u.first_name, u.last_name, u.email, r.resume_file
                FROM job_applications a
                JOIN job_postings j ON a.job_id = j.id
                LEFT JOIN employers e ON j.employer_id = e.id
                JOIN users u ON a.user_id = u.id
                LEFT JOIN resumes r ON u.id = r.user_id
                WHERE a.tenant_id = :tid
                ORDER BY a.applied_at DESC";
        return Database::fetchAll($sql, ['tid' => $tid]);
    }
}
