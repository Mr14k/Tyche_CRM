<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use App\Core\TenantContext;

class Batch extends Model
{
    protected string $table = 'batches';

    public function getBatchesWithCourse(): array
    {
        $tid = TenantContext::getTenantId();
        $sql = "SELECT b.*, c.title as course_title, c.slug as course_slug
                FROM batches b
                JOIN courses c ON b.course_id = c.id
                WHERE b.tenant_id = :tid
                ORDER BY b.start_date DESC";
        return Database::fetchAll($sql, ['tid' => $tid]);
    }

    public function getActiveForCourse(int $courseId): array
    {
        $tid = TenantContext::getTenantId();
        $sql = "SELECT * FROM batches 
                WHERE course_id = :course_id AND status IN ('upcoming', 'active') AND tenant_id = :tid
                ORDER BY start_date ASC";
        return Database::fetchAll($sql, ['course_id' => $courseId, 'tid' => $tid]);
    }
}
