<?php

declare(strict_types=1);

namespace App\Controllers\Faculty;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\TenantContext;
use App\Core\Database;
use App\Models\Course;
use App\Models\AssignmentSubmission;
use App\Models\ClassSchedule;
use App\Models\Batch;

class FacultyDashboardController extends Controller
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
        $facultyId = (int)$user['id'];
        $tid = TenantContext::getTenantId();

        $assignedCourses = Database::fetchAll("SELECT DISTINCT c.*, COALESCE(ci.role, 'Instructor') as instructor_role 
            FROM courses c
            LEFT JOIN course_instructors ci ON ci.course_id = c.id AND ci.user_id = :fid
            LEFT JOIN class_schedules cs ON cs.course_id = c.id AND cs.faculty_id = :fid
            WHERE c.tenant_id = :tid AND (ci.user_id = :fid OR cs.faculty_id = :fid)", ['fid' => $facultyId, 'tid' => $tid]);

        $pendingSubmissions = (new AssignmentSubmission())->getSubmissionsForFaculty($facultyId);

        // Fetch Faculty Dashboard Telemetry
        $telemetry = $this->scheduleModel->getFacultyTelemetry($facultyId);
        $upcomingClasses = $this->scheduleModel->getUpcomingClassesForFaculty($facultyId, 5);
        $upcomingQuizzes = $this->scheduleModel->getUpcomingQuizzesForFaculty($facultyId, 5);

        // Batches for Schedule Modal
        $batchModel = new Batch();
        $batches = Database::fetchAll("SELECT b.*, c.title as course_title FROM batches b JOIN courses c ON b.course_id = c.id WHERE b.tenant_id = :tid ORDER BY b.batch_name ASC", ['tid' => $tid]);

        $this->view('faculty.dashboard', [
            'pageTitle' => 'Faculty Teaching Workspace — Tyche Academy',
            'assignedCourses' => $assignedCourses,
            'pendingSubmissions' => $pendingSubmissions,
            'telemetry' => $telemetry,
            'upcomingClasses' => $upcomingClasses,
            'upcomingQuizzes' => $upcomingQuizzes,
            'batches' => $batches
        ], 'admin');
    }
}
