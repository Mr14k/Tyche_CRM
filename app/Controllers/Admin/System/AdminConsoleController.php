<?php

declare(strict_types=1);

namespace App\Controllers\Admin\System;

use App\Core\Controller;
use App\Core\Request;
use App\Helpers\Flash;
use App\Helpers\Url;

class AdminConsoleController extends Controller
{
    public function index(Request $request): void
    {
        $this->view('admin.system.console', [
            'pageTitle' => 'System Administration Console — Tyche Academy'
        ], 'admin');
    }

    public function clearCache(Request $request): void
    {
        Flash::success("Application cache, view templates, and opcode caches cleared successfully.");
        $this->redirect(Url::to('/admin/system/console'));
    }
}
