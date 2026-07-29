<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class LessonNote extends Model
{
    protected string $table = 'lesson_notes';

    public function getForStudentLesson(int $userId, int $lessonId): array
    {
        $sql = "SELECT * FROM lesson_notes WHERE user_id = :uid AND lesson_id = :lid ORDER BY timestamp_seconds ASC, created_at DESC";
        return Database::fetchAll($sql, ['uid' => $userId, 'lid' => $lessonId]);
    }
}
