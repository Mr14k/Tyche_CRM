<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Models\Certificate;
use App\Models\CourseEnrollment;
use App\Models\LessonProgress;
use App\Core\Database;

class CertificateService extends Service
{
    private Certificate $certModel;

    public function __construct()
    {
        $this->certModel = new Certificate();
    }

    public function issueCertificateIfEligible(int $userId, int $courseId): ?array
    {
        // Check existing certificate
        $existing = Database::fetchOne("SELECT * FROM certificates WHERE user_id = :uid AND course_id = :cid LIMIT 1", [
            'uid' => $userId,
            'cid' => $courseId
        ]);

        if ($existing) {
            return $existing;
        }

        // Verify 100% course completion
        $progressPct = (new LessonProgress())->getCourseProgressPercentage($userId, $courseId);
        if ($progressPct < 100) {
            return null;
        }

        // Generate Certificate Code & SHA-256 Digital Verification Hash
        $certCode = 'TYCHE-CERT-' . date('Y') . '-' . strtoupper(substr(md5(uniqid((string)$userId, true)), 0, 8));
        $hashRaw = "{$userId}:{$courseId}:{$certCode}:" . time();
        $verificationHash = hash('sha256', $hashRaw);

        $certId = $this->certModel->create([
            'certificate_code' => $certCode,
            'user_id' => $userId,
            'course_id' => $courseId,
            'issue_date' => date('Y-m-d H:i:s'),
            'final_score_percentage' => 100.00,
            'verification_hash' => $verificationHash,
            'is_valid' => 1
        ]);

        // Update enrollment status to completed
        Database::execute("UPDATE course_enrollments SET status = 'completed', completed_at = NOW() WHERE user_id = :uid AND course_id = :cid", [
            'uid' => $userId,
            'cid' => $courseId
        ]);

        return $this->certModel->find((int)$certId);
    }
}
