<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Payment extends Model
{
    protected string $table = 'payments';
    protected bool $timestamps = false;

    public function getPaymentsWithDetails(): array
    {
        $sql = "SELECT p.*, 
                       COALESCE(a.admission_number, 'DIRECT-ENROLL') as admission_number,
                       COALESCE(u.first_name, u_direct.first_name, 'Guest') as first_name, 
                       COALESCE(u.last_name, u_direct.last_name, '') as last_name, 
                       COALESCE(u.email, u_direct.email, '') as email, 
                       COALESCE(c.title, c_direct.title, 'Digital Marketing Mastery') as course_title
                FROM payments p
                LEFT JOIN admissions a ON p.admission_id = a.id
                LEFT JOIN users u ON a.user_id = u.id
                LEFT JOIN courses c ON a.course_id = c.id
                LEFT JOIN users u_direct ON p.user_id = u_direct.id
                LEFT JOIN courses c_direct ON p.course_id = c_direct.id
                ORDER BY p.payment_date DESC";
        return Database::fetchAll($sql);
    }
}
