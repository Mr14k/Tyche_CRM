<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class SystemNotification extends Model
{
    protected string $table = 'system_notifications';

    public function getForUser(int $userId): array
    {
        $sql = "SELECT * FROM system_notifications 
                WHERE user_id = :uid OR user_id IS NULL 
                ORDER BY created_at DESC LIMIT 20";
        return Database::fetchAll($sql, ['uid' => $userId]);
    }

    public function getUnreadCount(int $userId): int
    {
        $sql = "SELECT COUNT(*) as cnt FROM system_notifications 
                WHERE (user_id = :uid OR user_id IS NULL) AND is_read = 0";
        $res = Database::fetchOne($sql, ['uid' => $userId]);
        return $res ? (int)$res['cnt'] : 0;
    }

    public function markAsRead(int $id, int $userId): void
    {
        $sql = "UPDATE system_notifications SET is_read = 1 WHERE id = :id AND (user_id = :uid OR user_id IS NULL)";
        Database::execute($sql, ['id' => $id, 'uid' => $userId]);
    }
}
