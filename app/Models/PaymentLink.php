<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class PaymentLink extends Model
{
    protected string $table = 'payment_links';

    public function findByCode(string $code): ?array
    {
        $sql = "SELECT pl.*, l.first_name, l.last_name, l.email, l.phone, 
                       c.title as course_title, c.slug as course_slug,
                       b.batch_name
                FROM payment_links pl
                JOIN leads l ON pl.lead_id = l.id
                JOIN courses c ON pl.course_id = c.id
                LEFT JOIN batches b ON pl.batch_id = b.id
                WHERE pl.link_code = :code LIMIT 1";
        return Database::fetchOne($sql, ['code' => $code]);
    }
}
