<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Assignment extends Model
{
    protected string $table = 'assignments';

    public function getForCourse(int $courseId): array
    {
        $sql = "SELECT a.*, c.title as course_title FROM assignments a JOIN courses c ON a.course_id = c.id WHERE a.course_id = :cid ORDER BY a.due_date ASC";
        return Database::fetchAll($sql, ['cid' => $courseId]);
    }
}
