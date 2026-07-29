<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class ActivityLog extends Model
{
    protected string $table = 'activity_logs';

    public function record(?int $userId, string $module, string $action, string $description, string $ip): void
    {
        $this->create([
            'user_id' => $userId,
            'module' => $module,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ip
        ]);
    }
}
