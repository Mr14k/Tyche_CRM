<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class QuizAttempt extends Model
{
    protected string $table = 'quiz_attempts';

    public function getStudentAttempts(int $userId, int $quizId): array
    {
        $sql = "SELECT * FROM quiz_attempts WHERE user_id = :uid AND quiz_id = :qid ORDER BY attempt_number DESC";
        return Database::fetchAll($sql, ['uid' => $userId, 'qid' => $quizId]);
    }
}
