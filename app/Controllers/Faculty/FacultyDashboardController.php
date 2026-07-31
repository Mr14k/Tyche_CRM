<?php

declare(strict_types=1);

namespace App\Controllers\Faculty;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\TenantContext;
use App\Models\Course;
use App\Models\AssignmentSubmission;
use App\Core\Database;

class FacultyDashboardController extends Controller
{
    public function index(Request $request): void
    {
        $user = Session::get('user');
        $facultyId = (int)$user['id'];
        $tid = TenantContext::getTenantId();

        $assignedCourses = Database::fetchAll("SELECT c.*, ci.role as instructor_role 
            FROM course_instructors ci
            JOIN courses c ON ci.course_id = c.id
            WHERE ci.user_id = :fid AND ci.tenant_id = :tid", ['fid' => $facultyId, 'tid' => $tid]);

        $pendingSubmissions = (new AssignmentSubmission())->getSubmissionsForFaculty($facultyId);

        $this->view('faculty.dashboard', [
            'pageTitle' => 'Faculty Teaching Workspace — Tyche Academy',
            'assignedCourses' => $assignedCourses,
            'pendingSubmissions' => $pendingSubmissions
        ], 'admin');
    }
}
