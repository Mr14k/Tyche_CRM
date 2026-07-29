<?php

declare(strict_types=1);

namespace App\Widgets;

use App\Core\WidgetInterface;
use App\Core\Database;

class ActiveStudentsWidget implements WidgetInterface
{
    public function getKey(): string
    {
        return 'active_students';
    }

    public function getTitle(): string
    {
        return 'Active Students';
    }

    public function getRequiredPermission(): ?string
    {
        return 'USERS.View';
    }

    public function render(): string
    {
        $res = Database::fetchOne("SELECT COUNT(*) as cnt FROM users WHERE status = 'active'");
        $count = $res ? (int)$res['cnt'] : 0;

        return '<div class="card-custom p-4">
            <div class="text-muted small text-uppercase font-monospace">Active Students</div>
            <div class="display-6 font-monospace text-warning mt-2">' . $count . '</div>
            <div class="text-secondary small mt-1"><i class="bi bi-people"></i> Enrolled Platform Users</div>
        </div>';
    }
}
