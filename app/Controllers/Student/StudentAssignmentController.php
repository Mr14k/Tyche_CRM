<?php

declare(strict_types=1);

namespace App\Controllers\Student;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Helpers\Flash;
use App\Helpers\Url;

class StudentAssignmentController extends Controller
{
    private Assignment $assignmentModel;
    private AssignmentSubmission $submissionModel;

    public function __construct()
    {
        parent::__construct();
        $this->assignmentModel = new Assignment();
        $this->submissionModel = new AssignmentSubmission();
    }

    public function index(Request $request): void
    {
        $user = Session::get('user');
        $submissions = \App\Core\Database::fetchAll("SELECT sub.*, a.title as assignment_title, a.max_marks, c.title as course_title 
            FROM assignment_submissions sub
            JOIN assignments a ON sub.assignment_id = a.id
            JOIN courses c ON a.course_id = c.id
            WHERE sub.user_id = :uid ORDER BY sub.submitted_at DESC", ['uid' => $user['id']]);

        $assignments = \App\Core\Database::fetchAll("SELECT a.*, c.title as course_title 
            FROM assignments a
            JOIN course_enrollments ce ON a.course_id = ce.course_id
            JOIN courses c ON a.course_id = c.id
            WHERE ce.user_id = :uid", ['uid' => $user['id']]);

        $this->view('student.assignments', [
            'pageTitle' => 'Assignments & Capstone Projects — Tyche Academy',
            'submissions' => $submissions,
            'assignments' => $assignments
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $user = Session::get('user');
        $data = $this->validate($request, [
            'assignment_id' => 'required',
            'submission_type' => 'required'
        ]);

        $this->submissionModel->create([
            'assignment_id' => (int)$data['assignment_id'],
            'user_id' => (int)$user['id'],
            'submission_type' => $data['submission_type'],
            'github_url' => $request->input('github_url'),
            'submission_text' => $request->input('submission_text'),
            'status' => 'submitted'
        ]);

        Flash::success("Assignment submitted successfully to faculty workspace.");
        $this->redirect(Url::to('/student/assignments'));
    }
}
