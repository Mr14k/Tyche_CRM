<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class CourseEnrollment extends Model
{
    protected string $table = 'course_enrollments';

    public function isEnrolled(int $userId, int $courseId): bool
    {
        $sql = "SELECT id FROM course_enrollments 
                WHERE user_id = :uid AND course_id = :cid AND status = 'active' LIMIT 1";
        return (bool)Database::fetchOne($sql, ['uid' => $userId, 'cid' => $courseId]);
    }

    public function getStudentEnrollments(int $userId): array
    {
        $sql = "SELECT ce.*, c.title, c.slug, c.thumbnail, c.code
                FROM course_enrollments ce
                JOIN courses c ON ce.course_id = c.id
                WHERE ce.user_id = :uid AND ce.status = 'active'
                ORDER BY ce.enrolled_at DESC";
        return Database::fetchAll($sql, ['uid' => $userId]);
    }
}
