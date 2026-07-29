<?php

declare(strict_types=1);

namespace App\Widgets;

use App\Core\WidgetInterface;
use App\Helpers\Url;

class QuickActionsWidget implements WidgetInterface
{
    public function getKey(): string
    {
        return 'quick_actions';
    }

    public function getTitle(): string
    {
        return 'Quick Actions';
    }

    public function getRequiredPermission(): ?string
    {
        return null;
    }

    public function render(): string
    {
        return '<div class="card-custom p-4">
            <h6 class="font-monospace text-warning mb-3"><i class="bi bi-lightning-charge"></i> Quick Executive Shortcuts</h6>
            <div class="d-flex flex-wrap gap-2">
                <a href="' . Url::to('/admin/cms/pages/create') . '" class="btn btn-outline-warning btn-sm"><i class="bi bi-file-earmark-plus"></i> Create CMS Page</a>
                <a href="' . Url::to('/admin/cms/media') . '" class="btn btn-outline-info btn-sm"><i class="bi bi-images"></i> Media Library</a>
                <a href="' . Url::to('/admin/users') . '" class="btn btn-outline-light btn-sm"><i class="bi bi-person-plus"></i> Provision User</a>
                <a href="' . Url::to('/admin/cms/settings') . '" class="btn btn-outline-secondary btn-sm"><i class="bi bi-gear"></i> Global Settings</a>
            </div>
        </div>';
    }
}
