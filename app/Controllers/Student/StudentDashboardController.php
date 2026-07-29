<?php

declare(strict_types=1);

namespace App\Controllers\Student;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\CourseEnrollment;
use App\Models\StudentAchievement;
use App\Models\Certificate;
use App\Models\CourseAnnouncement;
use App\Core\Database;

class StudentDashboardController extends Controller
{
    public function index(Request $request): void
    {
        $user = Session::get('user');
        $userId = (int)$user['id'];

        $enrollments = (new CourseEnrollment())->getStudentEnrollments($userId);
        $achievements = Database::fetchAll("SELECT * FROM student_achievements WHERE user_id = :uid ORDER BY awarded_at DESC", ['uid' => $userId]);
        $certificates = Database::fetchAll("SELECT cert.*, c.title as course_title FROM certificates cert JOIN courses c ON cert.course_id = c.id WHERE cert.user_id = :uid", ['uid' => $userId]);
        $announcements = Database::fetchAll("SELECT ca.*, c.title as course_title FROM course_announcements ca JOIN course_enrollments ce ON ca.course_id = ce.course_id JOIN courses c ON ca.course_id = c.id WHERE ce.user_id = :uid ORDER BY ca.created_at DESC LIMIT 5", ['uid' => $userId]);

        $this->view('student.dashboard', [
            'pageTitle' => 'Student Digital Classroom — Tyche Academy',
            'enrollments' => $enrollments,
            'achievements' => $achievements,
            'certificates' => $certificates,
            'announcements' => $announcements
        ], 'admin');
    }
}
