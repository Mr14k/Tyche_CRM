<?php

declare(strict_types=1);

namespace App\Controllers\Admin\System;

use App\Core\Controller;
use App\Core\Request;
use App\Models\SystemBackup;
use App\Services\SystemAdminService;
use App\Helpers\Flash;
use App\Helpers\Url;

class BackupController extends Controller
{
    public function index(Request $request): void
    {
        $backups = (new SystemBackup())->all();
        $this->view('admin.system.backups', [
            'pageTitle' => 'Database Backup & Recovery — Tyche Academy',
            'backups' => $backups
        ], 'admin');
    }

    public function generate(Request $request): void
    {
        $service = new SystemAdminService();
        $backup = $service->createBackup();

        Flash::success("Database backup '{$backup['filename']}' generated successfully.");
        $this->redirect(Url::to('/admin/system/backups'));
    }
}
