<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Database;
use App\Helpers\Url;

class SearchService extends Service
{
    public function search(string $query): array
    {
        $query = trim($query);
        if (strlen($query) < 2) {
            return [];
        }

        $searchTerm = '%' . $query . '%';
        $results = [];

        // 1. Search Pages
        $pages = Database::fetchAll("SELECT id, title, slug FROM pages WHERE title LIKE :q1 OR content LIKE :q2 LIMIT 5", ['q1' => $searchTerm, 'q2' => $searchTerm]);
        foreach ($pages as $p) {
            $results[] = [
                'type' => 'CMS Page',
                'title' => $p['title'],
                'url' => Url::to('/admin/cms/pages/' . $p['id'] . '/edit'),
                'icon' => 'bi-file-earmark-text'
            ];
        }

        // 2. Search Users
        $users = Database::fetchAll("SELECT id, first_name, last_name, email FROM users WHERE first_name LIKE :q1 OR last_name LIKE :q2 OR email LIKE :q3 LIMIT 5", ['q1' => $searchTerm, 'q2' => $searchTerm, 'q3' => $searchTerm]);
        foreach ($users as $u) {
            $results[] = [
                'type' => 'User Account',
                'title' => $u['first_name'] . ' ' . $u['last_name'] . ' (' . $u['email'] . ')',
                'url' => Url::to('/admin/users'),
                'icon' => 'bi-person'
            ];
        }

        // 3. Search Media
        $media = Database::fetchAll("SELECT id, original_name, file_path FROM media_files WHERE original_name LIKE :q1 OR tags LIKE :q2 LIMIT 5", ['q1' => $searchTerm, 'q2' => $searchTerm]);
        foreach ($media as $m) {
            $results[] = [
                'type' => 'Media File',
                'title' => $m['original_name'],
                'url' => Url::to('/admin/cms/media'),
                'icon' => 'bi-image'
            ];
        }

        // 4. Search FAQs
        $faqs = Database::fetchAll("SELECT id, question FROM faqs WHERE question LIKE :q1 OR answer LIKE :q2 LIMIT 5", ['q1' => $searchTerm, 'q2' => $searchTerm]);
        foreach ($faqs as $f) {
            $results[] = [
                'type' => 'FAQ Item',
                'title' => $f['question'],
                'url' => Url::to('/admin/cms/faqs'),
                'icon' => 'bi-question-circle'
            ];
        }

        return $results;
    }
}
