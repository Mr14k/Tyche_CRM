<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Coupon extends Model
{
    protected string $table = 'coupons';

    public function findValidCode(string $code): ?array
    {
        $sql = "SELECT * FROM coupons WHERE code = :code AND is_active = 1 AND expires_at >= CURDATE() AND used_count < max_uses LIMIT 1";
        return \App\Core\Database::fetchOne($sql, ['code' => strtoupper($code)]);
    }
}
