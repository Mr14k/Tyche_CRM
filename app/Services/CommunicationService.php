<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Models\CommunicationLog;
use App\Models\SystemNotification;

class CommunicationService extends Service
{
    private CommunicationLog $logModel;

    public function __construct()
    {
        $this->logModel = new CommunicationLog();
    }

    public function dispatchNotification(string $channel, string $recipient, string $subject, string $body, ?int $userId = null): void
    {
        // 1. Log to communication history
        $this->logModel->create([
            'user_id' => $userId,
            'recipient' => $recipient,
            'channel' => $channel,
            'subject' => $subject,
            'message_body' => $body,
            'status' => 'sent'
        ]);

        // 2. If in-app notification, insert into system_notifications
        if ($userId && ($channel === 'in_app' || $channel === 'email')) {
            (new SystemNotification())->create([
                'user_id' => $userId,
                'type' => 'system',
                'title' => $subject,
                'message' => substr(strip_tags($body), 0, 200),
                'action_url' => '/dashboard'
            ]);
        }
    }
}
