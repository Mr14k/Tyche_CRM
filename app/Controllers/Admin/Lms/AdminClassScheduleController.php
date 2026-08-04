<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Lms;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\TenantContext;
use App\Core\Database;
use App\Models\ClassSchedule;
use App\Services\ClassScheduleService;
use App\Helpers\Flash;
use App\Helpers\Url;
use App\Exceptions\ValidationException;

class AdminClassScheduleController extends Controller
{
    private ClassSchedule $scheduleModel;
    private ClassScheduleService $scheduleService;

    public function __construct()
    {
        parent::__construct();
        $this->scheduleModel = new ClassSchedule();
        $this->scheduleService = new ClassScheduleService();
    }

    public function index(Request $request): void
    {
        $tid = TenantContext::getTenantId();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $schedules = $this->scheduleModel->getAllTenantSchedules($startDate, $endDate);
        
        $courses = Database::fetchAll("SELECT id, title, code FROM courses WHERE tenant_id = :tid ORDER BY title ASC", ['tid' => $tid]);
        $batches = Database::fetchAll("SELECT b.*, c.title as course_title FROM batches b JOIN courses c ON b.course_id = c.id WHERE b.tenant_id = :tid ORDER BY b.batch_name ASC", ['tid' => $tid]);
        $facultyList = Database::fetchAll("SELECT id, first_name, last_name, email FROM users WHERE tenant_id = :tid ORDER BY first_name ASC", ['tid' => $tid]);

        $this->view('admin.lms.schedules', [
            'pageTitle' => 'Institute Class Timetables & Live Streaming Center — Tyche Admin',
            'schedules' => $schedules,
            'courses' => $courses,
            'batches' => $batches,
            'facultyList' => $facultyList,
            'filters' => ['start_date' => $startDate, 'end_date' => $endDate]
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $user = Session::get('user');

        try {
            $data = $request->all();
            $this->scheduleService->createSchedule($data, (int)$user['id'], 'admin');
            Flash::success("Class schedule assigned & created successfully!");
        } catch (ValidationException $e) {
            Flash::error($e->getMessage());
        }

        $this->redirect(Url::to('/admin/lms/schedules'));
    }

    public function toggleGoLive(Request $request, string $id): void
    {
        $user = Session::get('user');

        try {
            $res = $this->scheduleService->toggleGoLive((int)$id, (int)$user['id']);
            Flash::success($res['message']);
        } catch (ValidationException $e) {
            Flash::error($e->getMessage());
        }

        $this->redirect(Url::to('/admin/lms/schedules'));
    }
}
