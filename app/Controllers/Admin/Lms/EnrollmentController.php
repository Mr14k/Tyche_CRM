<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Lms;

use App\Core\Controller;
use App\Core\Request;
use App\Core\TenantContext;
use App\Models\CourseEnrollment;
use App\Models\Course;
use App\Models\User;
use App\Helpers\Flash;
use App\Helpers\Url;

class EnrollmentController extends Controller
{
    private CourseEnrollment $enrollmentModel;

    public function __construct()
    {
        parent::__construct();
        $this->enrollmentModel = new CourseEnrollment();
    }

    public function index(Request $request): void
    {
        $tid = TenantContext::getTenantId();
        $enrollments = \App\Core\Database::fetchAll("SELECT ce.*, u.first_name, u.last_name, u.email, c.title as course_title, c.code 
            FROM course_enrollments ce
            JOIN users u ON ce.user_id = u.id
            JOIN courses c ON ce.course_id = c.id
            WHERE ce.tenant_id = :tid
            ORDER BY ce.enrolled_at DESC", ['tid' => $tid]);

        $courses = (new Course())->all();
        $students = (new User())->all();

        $this->view('admin.lms.enrollments', [
            'pageTitle' => 'Student Course Enrollments — Tyche Academy',
            'enrollments' => $enrollments,
            'courses' => $courses,
            'students' => $students
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'user_id' => 'required',
            'course_id' => 'required'
        ]);

        $this->enrollmentModel->create([
            'user_id' => (int)$data['user_id'],
            'course_id' => (int)$data['course_id'],
            'status' => 'active'
        ]);

        Flash::success("Student successfully enrolled in course.");
        $this->redirect(Url::to('/admin/lms/enrollments'));
    }
}
