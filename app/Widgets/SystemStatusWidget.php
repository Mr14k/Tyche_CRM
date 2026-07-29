<?php

declare(strict_types=1);

namespace App\Widgets;

use App\Core\WidgetInterface;

class SystemStatusWidget implements WidgetInterface
{
    public function getKey(): string
    {
        return 'system_status';
    }

    public function getTitle(): string
    {
        return 'System Status';
    }

    public function getRequiredPermission(): ?string
    {
        return null;
    }

    public function render(): string
    {
        return '<div class="card-custom p-4">
            <div class="text-muted small text-uppercase font-monospace">Core System Health</div>
            <div class="display-6 font-monospace text-success mt-2">Optimal</div>
            <div class="text-secondary small mt-1"><i class="bi bi-cpu"></i> PHP 8.2 • MySQL Active</div>
        </div>';
    }
}
