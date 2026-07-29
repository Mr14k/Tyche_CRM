<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Course extends Model
{
    protected string $table = 'courses';

    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT c.*, cc.name as category_name, u.first_name, u.last_name, u.avatar as instructor_avatar
                FROM courses c
                LEFT JOIN course_categories cc ON c.category_id = cc.id
                JOIN users u ON c.created_by = u.id
                WHERE c.slug = :slug LIMIT 1";
        return Database::fetchOne($sql, ['slug' => $slug]);
    }

    public function getPublishedCatalog(): array
    {
        $sql = "SELECT c.*, cc.name as category_name 
                FROM courses c
                LEFT JOIN course_categories cc ON c.category_id = cc.id
                WHERE c.status = 'published'
                ORDER BY c.created_at DESC";
        return Database::fetchAll($sql);
    }

    public function getFullHierarchy(int $courseId): array
    {
        $modules = Database::fetchAll("SELECT * FROM course_modules WHERE course_id = :cid ORDER BY sort_order ASC", ['cid' => $courseId]);

        foreach ($modules as &$mod) {
            $chapters = Database::fetchAll("SELECT * FROM course_chapters WHERE module_id = :mid ORDER BY sort_order ASC", ['mid' => $mod['id']]);

            foreach ($chapters as &$chap) {
                $lessons = Database::fetchAll("SELECT * FROM course_lessons WHERE chapter_id = :chid ORDER BY sort_order ASC", ['chid' => $chap['id']]);

                foreach ($lessons as &$les) {
                    $les['resources'] = Database::fetchAll("SELECT * FROM lesson_resources WHERE lesson_id = :lid", ['lid' => $les['id']]);
                }
                $chap['lessons'] = $lessons;
            }
            $mod['chapters'] = $chapters;
        }

        return $modules;
    }
}
