<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class UserSession extends Model
{
    protected string $table = 'user_sessions';

    public function createOrUpdateSession(string $sessionId, int $userId, string $ip, ?string $userAgent): void
    {
        $sql = "INSERT INTO user_sessions (id, user_id, ip_address, user_agent, last_activity) 
                VALUES (:id, :user_id, :ip, :ua, NOW()) 
                ON DUPLICATE KEY UPDATE ip_address = VALUES(ip_address), user_agent = VALUES(user_agent), last_activity = NOW()";
        Database::execute($sql, [
            'id' => $sessionId,
            'user_id' => $userId,
            'ip' => $ip,
            'ua' => $userAgent
        ]);
    }

    public function deleteSession(string $sessionId): void
    {
        Database::execute("DELETE FROM user_sessions WHERE id = :id", ['id' => $sessionId]);
    }
}
