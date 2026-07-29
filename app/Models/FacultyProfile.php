<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class FacultyProfile extends Model
{
    protected string $table = 'faculty_profiles';

    public function getFeatured(): array
    {
        $sql = "SELECT * FROM faculty_profiles WHERE is_featured = 1 ORDER BY sort_order ASC";
        return Database::fetchAll($sql);
    }
}
