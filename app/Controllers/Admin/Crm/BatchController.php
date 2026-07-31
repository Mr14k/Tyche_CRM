<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Crm;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Database;
use App\Core\TenantContext;
use App\Models\Batch;
use App\Helpers\Flash;
use App\Helpers\Url;

class BatchController extends Controller
{
    private Batch $batchModel;

    public function __construct()
    {
        parent::__construct();
        $this->batchModel = new Batch();
    }

    public function index(Request $request): void
    {
        $tid = TenantContext::getTenantId();
        $batches = $this->batchModel->getBatchesWithCourse();
        $courses = Database::fetchAll("SELECT id, title FROM courses WHERE tenant_id = :tid ORDER BY title ASC", ['tid' => $tid]);

        $this->view('admin.crm.batches.index', [
            'pageTitle' => 'Course Batch Scheduling & Seats Management — Tyche Admin',
            'batches' => $batches,
            'courses' => $courses
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'course_id' => 'required',
            'batch_name' => 'required',
            'start_date' => 'required'
        ]);

        $this->batchModel->create([
            'course_id' => (int)$data['course_id'],
            'batch_name' => $data['batch_name'],
            'start_date' => $data['start_date'],
            'end_date' => !empty($request->input('end_date')) ? $request->input('end_date') : null,
            'schedule_type' => $request->input('schedule_type', 'weekend'),
            'capacity' => (int)$request->input('capacity', 30),
            'seats_filled' => 0,
            'status' => 'upcoming',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Flash::success("New academic cohort batch '{$data['batch_name']}' created successfully!");
        $this->redirect(Url::to('/admin/crm/batches'));
    }
}
