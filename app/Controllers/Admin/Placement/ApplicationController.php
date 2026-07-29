<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Placement;

use App\Core\Controller;
use App\Core\Request;
use App\Models\JobApplication;
use App\Helpers\Flash;
use App\Helpers\Url;

class ApplicationController extends Controller
{
    public function index(Request $request): void
    {
        $applications = (new JobApplication())->getApplicationsWithDetails();
        $this->view('admin.placement.applications', [
            'pageTitle' => 'Student Job Applications & Interviews — Tyche Academy',
            'applications' => $applications
        ], 'admin');
    }

    public function updateStatus(Request $request, string $id): void
    {
        $status = (string)$request->input('status');
        (new JobApplication())->update((int)$id, ['status' => $status]);

        Flash::success("Job application status updated to '{$status}'.");
        $this->redirect(Url::to('/admin/placement/applications'));
    }
}
