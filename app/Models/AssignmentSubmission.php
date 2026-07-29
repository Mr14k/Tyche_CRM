<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class AssignmentSubmission extends Model
{
    protected string $table = 'assignment_submissions';

    public function getSubmissionsForFaculty(int $facultyId): array
    {
        $sql = "SELECT sub.*, a.title as assignment_title, c.title as course_title, u.first_name, u.last_name, u.email 
                FROM assignment_submissions sub
                JOIN assignments a ON sub.assignment_id = a.id
                JOIN courses c ON a.course_id = c.id
                JOIN users u ON sub.user_id = u.id
                ORDER BY sub.submitted_at DESC";
        return Database::fetchAll($sql);
    }
}
