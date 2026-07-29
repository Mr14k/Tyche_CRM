<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class BlogPost extends Model
{
    protected string $table = 'blog_posts';

    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT bp.*, bc.name as category_name, u.first_name, u.last_name, u.avatar 
                FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE bp.slug = :slug LIMIT 1";
        return Database::fetchOne($sql, ['slug' => $slug]);
    }

    public function getPublishedWithCategory(): array
    {
        $sql = "SELECT bp.*, bc.name as category_name, u.first_name, u.last_name 
                FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                LEFT JOIN users u ON bp.author_id = u.id
                WHERE bp.status = 'published'
                ORDER BY bp.is_sticky DESC, bp.published_at DESC";
        return Database::fetchAll($sql);
    }

    public function getAllWithDetails(): array
    {
        $sql = "SELECT bp.*, bc.name as category_name, u.first_name, u.last_name 
                FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                LEFT JOIN users u ON bp.author_id = u.id
                ORDER BY bp.created_at DESC";
        return Database::fetchAll($sql);
    }
}
