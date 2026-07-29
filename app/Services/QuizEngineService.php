<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use App\Core\Database;

class QuizEngineService extends Service
{
    private Quiz $quizModel;
    private QuizAttempt $attemptModel;

    public function __construct()
    {
        $this->quizModel = new Quiz();
        $this->attemptModel = new QuizAttempt();
    }

    public function evaluateAttempt(int $attemptId, array $submittedAnswers): array
    {
        $attempt = $this->attemptModel->find($attemptId);
        if (!$attempt || $attempt['status'] === 'completed') {
            return $attempt ?: [];
        }

        $quiz = $this->quizModel->getFullQuizWithQuestions((int)$attempt['quiz_id']);
        if (!$quiz) return [];

        $totalMarks = 0;
        $scoreObtained = 0;

        foreach ($quiz['questions'] as $question) {
            $qId = (int)$question['id'];
            $marks = (float)$question['marks'];
            $totalMarks += $marks;

            $selectedOptionId = isset($submittedAnswers[$qId]) ? (int)$submittedAnswers[$qId] : null;
            $isCorrect = false;
            $awardedMarks = 0.00;

            if ($selectedOptionId) {
                $correctOpt = Database::fetchOne("SELECT id FROM quiz_options WHERE question_id = :qid AND is_correct = 1 LIMIT 1", ['qid' => $qId]);
                if ($correctOpt && (int)$correctOpt['id'] === $selectedOptionId) {
                    $isCorrect = true;
                    $awardedMarks = $marks;
                    $scoreObtained += $marks;
                }
            }

            (new QuizAttemptAnswer())->create([
                'attempt_id' => $attemptId,
                'question_id' => $qId,
                'selected_option_id' => $selectedOptionId,
                'marks_awarded' => $awardedMarks,
                'is_correct' => $isCorrect ? 1 : 0
            ]);
        }

        $percentage = $totalMarks > 0 ? (float)round(($scoreObtained / $totalMarks) * 100, 2) : 0.00;
        $isPassed = $percentage >= (float)$quiz['passing_score_percentage'];

        $this->attemptModel->update($attemptId, [
            'score_obtained' => $scoreObtained,
            'total_marks' => $totalMarks,
            'percentage' => $percentage,
            'is_passed' => $isPassed ? 1 : 0,
            'status' => 'completed',
            'completed_at' => date('Y-m-d H:i:s')
        ]);

        return [
            'attempt_id' => $attemptId,
            'score_obtained' => $scoreObtained,
            'total_marks' => $totalMarks,
            'percentage' => $percentage,
            'is_passed' => $isPassed
        ];
    }
}
