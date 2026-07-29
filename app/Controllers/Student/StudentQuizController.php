<?php

declare(strict_types=1);

namespace App\Controllers\Student;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\QuizEngineService;
use App\Helpers\Flash;
use App\Helpers\Url;
use App\Exceptions\NotFoundException;

class StudentQuizController extends Controller
{
    private Quiz $quizModel;
    private QuizAttempt $attemptModel;

    public function __construct()
    {
        parent::__construct();
        $this->quizModel = new Quiz();
        $this->attemptModel = new QuizAttempt();
    }

    public function show(Request $request, string $id): void
    {
        $user = Session::get('user');
        $quiz = $this->quizModel->getFullQuizWithQuestions((int)$id);
        if (!$quiz) {
            throw new NotFoundException("Quiz not found.");
        }

        $attempts = $this->attemptModel->getStudentAttempts((int)$user['id'], (int)$id);

        $this->view('student.quiz', [
            'pageTitle' => "Quiz Assessment: {$quiz['title']} — Tyche Academy",
            'quiz' => $quiz,
            'attempts' => $attempts
        ], 'admin');
    }

    public function submit(Request $request, string $id): void
    {
        $user = Session::get('user');
        $answers = $request->input('answers', []);

        // Record initial attempt
        $attemptId = $this->attemptModel->create([
            'quiz_id' => (int)$id,
            'user_id' => (int)$user['id'],
            'status' => 'in_progress'
        ]);

        $service = new QuizEngineService();
        $result = $service->evaluateAttempt((int)$attemptId, $answers);

        if ($result['is_passed']) {
            Flash::success("Congratulations! You passed the quiz with {$result['percentage']}% score.");
        } else {
            Flash::error("You scored {$result['percentage']}%. Required score to pass is 70%. Please review material and retake.");
        }

        $this->redirect(Url::to('/student/quizzes/' . $id));
    }
}
