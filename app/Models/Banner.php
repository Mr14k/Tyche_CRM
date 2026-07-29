<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Banner extends Model
{
    protected string $table = 'banners';

    public function getActiveByType(string $type): array
    {
        $sql = "SELECT * FROM banners 
                WHERE type = :type AND is_active = 1 
                AND (start_date IS NULL OR start_date <= NOW()) 
                AND (end_date IS NULL OR end_date >= NOW())";
        return Database::fetchAll($sql, ['type' => $type]);
    }
}
