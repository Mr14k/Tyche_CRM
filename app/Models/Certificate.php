<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Certificate extends Model
{
    protected string $table = 'certificates';

    public function findByCode(string $code): ?array
    {
        $sql = "SELECT cert.*, u.first_name, u.last_name, u.email, c.title as course_title, c.code as course_code
                FROM certificates cert
                JOIN users u ON cert.user_id = u.id
                JOIN courses c ON cert.course_id = c.id
                WHERE cert.certificate_code = :code LIMIT 1";
        return Database::fetchOne($sql, ['code' => $code]);
    }
}
