<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Permission extends Model
{
    protected string $table = 'permissions';

    public function getAllGroupedByModule(): array
    {
        $all = $this->all();
        $grouped = [];
        foreach ($all as $perm) {
            $grouped[$perm['module']][] = $perm;
        }
        return $grouped;
    }
}
