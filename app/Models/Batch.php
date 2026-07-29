<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Batch extends Model
{
    protected string $table = 'batches';

    public function getBatchesWithCourse(): array
    {
        $sql = "SELECT b.*, c.title as course_title, c.slug as course_slug
                FROM batches b
                JOIN courses c ON b.course_id = c.id
                ORDER BY b.start_date DESC";
        return Database::fetchAll($sql);
    }

    public function getActiveForCourse(int $courseId): array
    {
        $sql = "SELECT * FROM batches 
                WHERE course_id = :course_id AND status IN ('upcoming', 'active') 
                ORDER BY start_date ASC";
        return Database::fetchAll($sql, ['course_id' => $courseId]);
    }
}
