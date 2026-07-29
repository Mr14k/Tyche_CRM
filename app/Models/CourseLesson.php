<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class CourseLesson extends Model
{
    protected string $table = 'course_lessons';

    public function findWithDetails(int $id): ?array
    {
        $sql = "SELECT cl.*, ch.module_id, cm.course_id, c.title as course_title, c.slug as course_slug, c.allow_skip_lessons
                FROM course_lessons cl
                JOIN course_chapters ch ON cl.chapter_id = ch.id
                JOIN course_modules cm ON ch.module_id = cm.id
                JOIN courses c ON cm.course_id = c.id
                WHERE cl.id = :id LIMIT 1";
        return Database::fetchOne($sql, ['id' => $id]);
    }
}
