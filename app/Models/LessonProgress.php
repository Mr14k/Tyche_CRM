<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class LessonProgress extends Model
{
    protected string $table = 'lesson_progress';

    public function recordProgress(int $userId, int $lessonId, int $watchSeconds, bool $isCompleted): void
    {
        $completedAt = $isCompleted ? date('Y-m-d H:i:s') : null;
        $sql = "INSERT INTO lesson_progress (user_id, lesson_id, watch_seconds, is_completed, completed_at, last_accessed_at)
                VALUES (:uid, :lid, :watch, :comp, :comp_at, NOW())
                ON DUPLICATE KEY UPDATE 
                watch_seconds = GREATEST(watch_seconds, VALUES(watch_seconds)),
                is_completed = IF(is_completed = 1, 1, VALUES(is_completed)),
                completed_at = IF(is_completed = 1, completed_at, VALUES(completed_at)),
                last_accessed_at = NOW()";

        Database::execute($sql, [
            'uid' => $userId,
            'lid' => $lessonId,
            'watch' => $watchSeconds,
            'comp' => $isCompleted ? 1 : 0,
            'comp_at' => $completedAt
        ]);
    }

    public function getCourseProgressPercentage(int $userId, int $courseId): int
    {
        $totalLessons = Database::fetchOne("SELECT COUNT(cl.id) as cnt 
            FROM course_lessons cl
            JOIN course_chapters ch ON cl.chapter_id = ch.id
            JOIN course_modules cm ON ch.module_id = cm.id
            WHERE cm.course_id = :cid", ['cid' => $courseId]);

        $totalCount = $totalLessons ? (int)$totalLessons['cnt'] : 0;
        if ($totalCount === 0) return 0;

        $completedLessons = Database::fetchOne("SELECT COUNT(lp.lesson_id) as cnt 
            FROM lesson_progress lp
            JOIN course_lessons cl ON lp.lesson_id = cl.id
            JOIN course_chapters ch ON cl.chapter_id = ch.id
            JOIN course_modules cm ON ch.module_id = cm.id
            WHERE lp.user_id = :uid AND cm.course_id = :cid AND lp.is_completed = 1", ['uid' => $userId, 'cid' => $courseId]);

        $completedCount = $completedLessons ? (int)$completedLessons['cnt'] : 0;
        return (int)round(($completedCount / $totalCount) * 100);
    }
}
