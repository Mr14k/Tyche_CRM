<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Bi;

use App\Core\Controller;
use App\Core\Request;
use App\Services\BusinessIntelligenceService;

class BiDashboardController extends Controller
{
    public function index(Request $request): void
    {
        $service = new BusinessIntelligenceService();
        $metrics = $service->getExecutiveMetrics();

        $this->view('admin.bi.dashboard', [
            'pageTitle' => 'Executive BI Telemetry & Analytics — Tyche Academy',
            'metrics' => $metrics
        ], 'admin');
    }
}
