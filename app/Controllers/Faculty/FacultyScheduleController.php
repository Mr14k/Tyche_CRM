<?php

declare(strict_types=1);

namespace App\Controllers\Faculty;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\TenantContext;
use App\Core\Database;
use App\Models\ClassSchedule;
use App\Models\Batch;
use App\Services\ClassScheduleService;
use App\Helpers\Flash;
use App\Helpers\Url;
use App\Exceptions\ValidationException;

class FacultyScheduleController extends Controller
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
        $user = Session::get('user');
        $facultyId = (int)$user['id'];
        $tid = TenantContext::getTenantId();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $schedules = $this->scheduleModel->getFacultySchedules($facultyId, $startDate, $endDate);
        $telemetry = $this->scheduleModel->getFacultyTelemetry($facultyId);

        $assignedCourses = Database::fetchAll("SELECT DISTINCT c.*, COALESCE(ci.role, 'Instructor') as instructor_role 
            FROM courses c
            LEFT JOIN course_instructors ci ON ci.course_id = c.id AND ci.user_id = :fid1
            LEFT JOIN class_schedules cs ON cs.course_id = c.id AND cs.faculty_id = :fid2
            WHERE c.tenant_id = :tid AND (ci.user_id = :fid3 OR cs.faculty_id = :fid4)", [
                'fid1' => $facultyId,
                'fid2' => $facultyId,
                'fid3' => $facultyId,
                'fid4' => $facultyId,
                'tid' => $tid
            ]);
        $batches = Database::fetchAll("SELECT b.*, c.title as course_title FROM batches b JOIN courses c ON b.course_id = c.id WHERE b.tenant_id = :tid ORDER BY b.batch_name ASC", ['tid' => $tid]);

        $this->view('faculty.schedules', [
            'pageTitle' => 'Class Timetable & Digital Rooms — Faculty Workspace',
            'schedules' => $schedules,
            'telemetry' => $telemetry,
            'assignedCourses' => $assignedCourses,
            'batches' => $batches,
            'filters' => ['start_date' => $startDate, 'end_date' => $endDate]
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $user = Session::get('user');
        $facultyId = (int)$user['id'];
        $role = $user['role_name'] ?? 'faculty';

        try {
            $data = $request->all();
            $data['faculty_id'] = $facultyId;

            $this->scheduleService->createSchedule($data, $facultyId, $role);
            Flash::success("Class schedule created successfully! Digital room link generated.");
        } catch (ValidationException $e) {
            Flash::error($e->getMessage());
        }

        $redirectBack = $request->input('redirect_back', '') ?: Url::to('/faculty/dashboard');
        $this->redirect($redirectBack);
    }

    public function toggleGoLive(Request $request, string $id): void
    {
        $user = Session::get('user');

        try {
            $res = $this->scheduleService->toggleGoLive((int)$id, (int)$user['id']);
            if ($res['status'] === 'live') {
                Flash::success("🚀 Class is now LIVE! Digital Classroom Link: " . $res['meeting_link']);
            } else {
                Flash::info("Class marked as Completed.");
            }
        } catch (ValidationException $e) {
            Flash::error($e->getMessage());
        }

        $redirectBack = $request->input('redirect_back', '') ?: Url::to('/faculty/dashboard');
        $this->redirect($redirectBack);
    }

    public function updateStatus(Request $request, string $id): void
    {
        $status = (string)$request->input('status');

        try {
            $this->scheduleService->updateStatus((int)$id, $status);
            Flash::success("Class status updated to '" . strtoupper($status) . "'.");
        } catch (ValidationException $e) {
            Flash::error($e->getMessage());
        }

        $redirectBack = $request->input('redirect_back', '') ?: Url::to('/faculty/schedules');
        $this->redirect($redirectBack);
    }
}
