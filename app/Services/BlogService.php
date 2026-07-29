<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Models\BlogPost;
use App\Helpers\Format;

class BlogService extends Service
{
    private BlogPost $postModel;

    public function __construct()
    {
        $this->postModel = new BlogPost();
    }

    public function autoSaveDraft(int $authorId, ?int $postId, string $title, string $content, ?int $categoryId): array
    {
        $slug = Format::slug($title ?: 'draft-post-' . time());
        $readingTime = (int)ceil(str_word_count(strip_tags($content)) / 200);

        if ($postId && $postId > 0) {
            $this->postModel->update($postId, [
                'title' => $title ?: 'Untitled Draft',
                'slug' => $slug,
                'content' => $content,
                'category_id' => $categoryId,
                'reading_time_minutes' => max(1, $readingTime),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return ['status' => 'updated', 'post_id' => $postId, 'saved_at' => date('H:i:s')];
        }

        $newId = $this->postModel->create([
            'title' => $title ?: 'Untitled Draft',
            'slug' => $slug,
            'summary' => substr(strip_tags($content), 0, 160),
            'content' => $content,
            'category_id' => $categoryId,
            'author_id' => $authorId,
            'reading_time_minutes' => max(1, $readingTime),
            'status' => 'draft'
        ]);

        return ['status' => 'created', 'post_id' => (int)$newId, 'saved_at' => date('H:i:s')];
    }
}
