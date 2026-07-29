<?php

declare(strict_types=1);

namespace App\Controllers\Admin\System;

use App\Core\Controller;
use App\Core\Request;
use App\Services\SystemAdminService;

class HealthController extends Controller
{
    public function index(Request $request): void
    {
        $service = new SystemAdminService();
        $health = $service->getHealthStatus();

        $this->view('admin.system.health', [
            'pageTitle' => 'System Health Telemetry & Log Viewer — Tyche Academy',
            'health' => $health
        ], 'admin');
    }
}
