<?php

declare(strict_types=1);

namespace App\Controllers\Student;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\TenantContext;
use App\Core\Database;
use App\Models\ClassSchedule;

class StudentScheduleController extends Controller
{
    private ClassSchedule $scheduleModel;

    public function __construct()
    {
        parent::__construct();
        $this->scheduleModel = new ClassSchedule();
    }

    public function index(Request $request): void
    {
        $user = Session::get('user');
        $studentId = (int)$user['id'];
        $tid = TenantContext::getTenantId();

        // Get student's enrolled batch ID
        $enrollment = Database::fetchOne(
            "SELECT batch_id FROM course_enrollments WHERE tenant_id = :tid AND user_id = :sid AND status = 'active' LIMIT 1",
            ['tid' => $tid, 'sid' => $studentId]
        );

        $batchId = (int)($enrollment['batch_id'] ?? 0);
        $schedules = $this->scheduleModel->getStudentSchedulesForBatch($batchId);

        $this->view('student.schedules', [
            'pageTitle' => 'My Live Class Timetable & Digital Classroom — Student Portal',
            'schedules' => $schedules,
            'batchId' => $batchId
        ], 'student');
    }
}
