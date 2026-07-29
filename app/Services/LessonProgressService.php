<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Models\CourseLesson;
use App\Models\CourseEnrollment;
use App\Models\LessonProgress;
use App\Core\Database;
use App\Exceptions\AccessDeniedException;

class LessonProgressService extends Service
{
    private CourseLesson $lessonModel;
    private CourseEnrollment $enrollmentModel;
    private LessonProgress $progressModel;

    public function __construct()
    {
        $this->lessonModel = new CourseLesson();
        $this->enrollmentModel = new CourseEnrollment();
        $this->progressModel = new LessonProgress();
    }

    public function isLessonUnlocked(int $userId, int $lessonId): bool
    {
        $lesson = $this->lessonModel->findWithDetails($lessonId);
        if (!$lesson) return false;

        // Pre-preview lessons are open to all
        if ($lesson['is_preview']) return true;

        // Verify student enrollment
        if (!$this->enrollmentModel->isEnrolled($userId, (int)$lesson['course_id'])) {
            return false;
        }

        // If course allows skipping, lesson is unlocked
        if (!empty($lesson['allow_skip_lessons'])) {
            return true;
        }

        // Sequential Lesson Locking: Check if previous lesson in sequence is completed
        $prevLesson = Database::fetchOne("SELECT cl.id FROM course_lessons cl
            JOIN course_chapters ch ON cl.chapter_id = ch.id
            JOIN course_modules cm ON ch.module_id = cm.id
            WHERE cm.course_id = :cid AND (cm.sort_order < (SELECT cm2.sort_order FROM course_modules cm2 JOIN course_chapters ch2 ON ch2.module_id = cm2.id WHERE ch2.id = :chid1) OR (ch.id = :chid2 AND cl.sort_order < :sort))
            ORDER BY cm.sort_order DESC, ch.sort_order DESC, cl.sort_order DESC LIMIT 1", [
                'cid' => $lesson['course_id'],
                'chid1' => $lesson['chapter_id'],
                'chid2' => $lesson['chapter_id'],
                'sort' => $lesson['sort_order']
            ]);

        if (!$prevLesson) {
            // First lesson in course is unlocked
            return true;
        }

        $prevProgress = Database::fetchOne("SELECT is_completed FROM lesson_progress WHERE user_id = :uid AND lesson_id = :lid LIMIT 1", [
            'uid' => $userId,
            'lid' => $prevLesson['id']
        ]);

        return $prevProgress && (int)$prevProgress['is_completed'] === 1;
    }

    public function getSignedVideoUrl(int $userId, int $lessonId): string
    {
        $lesson = $this->lessonModel->findWithDetails($lessonId);
        if (!$lesson) {
            throw new AccessDeniedException("Lesson not found.");
        }

        if (!$this->isLessonUnlocked($userId, $lessonId)) {
            throw new AccessDeniedException("Sequential Lesson Locked: Please complete previous lesson first.");
        }

        // Generate session-bound signed token
        $expires = time() + 3600; // 1 hour token
        $token = hash_hmac('sha256', "{$userId}:{$lessonId}:{$expires}", $_ENV['APP_NAME'] ?? 'Tyche');

        return $lesson['video_url'] . (str_contains($lesson['video_url'], '?') ? '&' : '?') . "st={$token}&exp={$expires}";
    }
}
