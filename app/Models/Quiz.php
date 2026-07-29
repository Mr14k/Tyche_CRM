<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Quiz extends Model
{
    protected string $table = 'quizzes';

    public function getFullQuizWithQuestions(int $quizId): ?array
    {
        $quiz = $this->find($quizId);
        if (!$quiz) return null;

        $questions = Database::fetchAll("SELECT * FROM quiz_questions WHERE quiz_id = :qid ORDER BY sort_order ASC", ['qid' => $quizId]);
        foreach ($questions as &$q) {
            $q['options'] = Database::fetchAll("SELECT * FROM quiz_options WHERE question_id = :qid ORDER BY sort_order ASC", ['qid' => $q['id']]);
        }
        $quiz['questions'] = $questions;

        return $quiz;
    }
}
