<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Models\SystemNotification;

class NotificationService extends Service
{
    private SystemNotification $model;

    public function __construct()
    {
        $this->model = new SystemNotification();
    }

    public function getUserNotifications(int $userId): array
    {
        return $this->model->getForUser($userId);
    }

    public function getUnreadCount(int $userId): int
    {
        return $this->model->getUnreadCount($userId);
    }

    public function markAsRead(int $notificationId, int $userId): void
    {
        $this->model->markAsRead($notificationId, $userId);
    }

    public function dispatch(?int $userId, string $type, string $title, string $message, ?string $actionUrl = null): void
    {
        $this->model->create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'action_url' => $actionUrl,
            'is_read' => 0
        ]);
    }
}
