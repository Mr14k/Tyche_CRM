<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class NavigationMenu extends Model
{
    protected string $table = 'navigation_menus';

    public function getByLocation(string $location): array
    {
        $sql = "SELECT * FROM navigation_menus WHERE location = :loc AND is_active = 1 ORDER BY sort_order ASC";
        return Database::fetchAll($sql, ['loc' => $location]);
    }
}
