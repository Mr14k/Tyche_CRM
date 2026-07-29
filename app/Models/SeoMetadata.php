<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class SeoMetadata extends Model
{
    protected string $table = 'seo_metadata';

    public function findForEntity(string $entityType, int $entityId): ?array
    {
        $sql = "SELECT * FROM seo_metadata WHERE entity_type = :type AND entity_id = :id LIMIT 1";
        return Database::fetchOne($sql, ['type' => $entityType, 'id' => $entityId]);
    }

    public function saveForEntity(string $entityType, int $entityId, array $data): void
    {
        $sql = "INSERT INTO seo_metadata (entity_type, entity_id, meta_title, meta_description, keywords, canonical_url, og_title, og_description, og_image, robots)
                VALUES (:entity_type, :entity_id, :meta_title, :meta_description, :keywords, :canonical_url, :og_title, :og_description, :og_image, :robots)
                ON DUPLICATE KEY UPDATE 
                meta_title = VALUES(meta_title),
                meta_description = VALUES(meta_description),
                keywords = VALUES(keywords),
                canonical_url = VALUES(canonical_url),
                og_title = VALUES(og_title),
                og_description = VALUES(og_description),
                og_image = VALUES(og_image),
                robots = VALUES(robots)";

        Database::execute($sql, [
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'keywords' => $data['keywords'] ?? null,
            'canonical_url' => $data['canonical_url'] ?? null,
            'og_title' => $data['og_title'] ?? null,
            'og_description' => $data['og_description'] ?? null,
            'og_image' => $data['og_image'] ?? null,
            'robots' => $data['robots'] ?? 'index, follow'
        ]);
    }
}
