<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class LoginHistory extends Model
{
    protected string $table = 'login_history';

    public function record(?int $userId, string $email, string $ip, ?string $userAgent, string $status): void
    {
        $this->create([
            'user_id' => $userId,
            'email_attempted' => $email,
            'ip_address' => $ip,
            'user_agent' => $userAgent ? substr($userAgent, 0, 500) : null,
            'status' => $status
        ]);
    }
}
