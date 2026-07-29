<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Faq extends Model
{
    protected string $table = 'faqs';

    public function getActiveGroupedByCategory(): array
    {
        $all = Database::fetchAll("SELECT * FROM faqs WHERE is_active = 1 ORDER BY category, sort_order ASC");
        $grouped = [];
        foreach ($all as $faq) {
            $grouped[$faq['category']][] = $faq;
        }
        return $grouped;
    }
}
