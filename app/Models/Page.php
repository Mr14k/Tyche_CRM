<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Page extends Model
{
    protected string $table = 'pages';

    public function findBySlug(string $slug): ?array
    {
        return $this->findOneWhere('slug', strtolower(trim($slug)));
    }

    public function createWithRevision(array $data, int $authorId): string|false
    {
        $data['author_id'] = $authorId;
        $pageId = $this->create($data);

        if ($pageId) {
            (new PageRevision())->create([
                'page_id' => (int)$pageId,
                'title' => $data['title'],
                'content' => $data['content'] ?? '',
                'created_by' => $authorId
            ]);
        }
        return $pageId;
    }

    public function updateWithRevision(int $id, array $data, int $userId): int
    {
        $affected = $this->update($id, $data);

        // Record revision & cap to last 10 revisions
        $revisionModel = new PageRevision();
        $revisionModel->create([
            'page_id' => $id,
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
            'created_by' => $userId
        ]);
        $revisionModel->enforceRevisionCap($id, 10);

        return $affected;
    }
}
