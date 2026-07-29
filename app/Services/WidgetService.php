<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\WidgetInterface;
use App\Widgets\ActiveStudentsWidget;
use App\Widgets\TotalLeadsWidget;
use App\Widgets\SystemStatusWidget;
use App\Widgets\QuickActionsWidget;

class WidgetService extends Service
{
    private array $widgets = [];

    public function __construct()
    {
        $this->register(new ActiveStudentsWidget());
        $this->register(new TotalLeadsWidget());
        $this->register(new SystemStatusWidget());
        $this->register(new QuickActionsWidget());
    }

    public function register(WidgetInterface $widget): void
    {
        $this->widgets[$widget->getKey()] = $widget;
    }

    public function renderAllAuthorized(): array
    {
        $htmlList = [];
        foreach ($this->widgets as $key => $widget) {
            $perm = $widget->getRequiredPermission();
            if ($perm === null || RbacService::hasPermission($perm)) {
                $htmlList[$key] = $widget->render();
            }
        }
        return $htmlList;
    }
}
