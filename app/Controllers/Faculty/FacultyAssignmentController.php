<?php

declare(strict_types=1);

namespace App\Controllers\Faculty;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\AssignmentSubmission;
use App\Helpers\Flash;
use App\Helpers\Url;

class FacultyAssignmentController extends Controller
{
    private AssignmentSubmission $submissionModel;

    public function __construct()
    {
        parent::__construct();
        $this->submissionModel = new AssignmentSubmission();
    }

    public function index(Request $request): void
    {
        $user = Session::get('user');
        $submissions = $this->submissionModel->getSubmissionsForFaculty((int)$user['id']);

        $this->view('faculty.assignments', [
            'pageTitle' => 'Assignment Grading & Review Hub — Tyche Academy',
            'submissions' => $submissions
        ], 'admin');
    }

    public function grade(Request $request, string $id): void
    {
        $user = Session::get('user');
        $data = $this->validate($request, [
            'marks_awarded' => 'required|numeric',
            'status' => 'required'
        ]);

        $this->submissionModel->update((int)$id, [
            'marks_awarded' => (int)$data['marks_awarded'],
            'feedback_notes' => $request->input('feedback_notes'),
            'status' => $data['status'],
            'graded_by' => (int)$user['id'],
            'graded_at' => date('Y-m-d H:i:s')
        ]);

        Flash::success("Assignment graded successfully.");
        $this->redirect(Url::to('/faculty/assignments'));
    }
}
