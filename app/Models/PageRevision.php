<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class PageRevision extends Model
{
    protected string $table = 'page_revisions';

    public function getForPage(int $pageId): array
    {
        $sql = "SELECT pr.*, u.first_name, u.last_name FROM page_revisions pr 
                JOIN users u ON pr.created_by = u.id 
                WHERE pr.page_id = :page_id 
                ORDER BY pr.created_at DESC";
        return Database::fetchAll($sql, ['page_id' => $pageId]);
    }

    public function enforceRevisionCap(int $pageId, int $maxRevisions = 10): void
    {
        $revisions = $this->getForPage($pageId);
        if (count($revisions) > $maxRevisions) {
            $toDelete = array_slice($revisions, $maxRevisions);
            foreach ($toDelete as $rev) {
                $this->delete((int)$rev['id']);
            }
        }
    }
}
