<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Helpers\Logger;

class MailService extends Service
{
    public static function send(string $to, string $subject, string $body): bool
    {
        // Log outgoing email simulation in dev mode
        Logger::info("Email Dispatch to [{$to}]: Subject: {$subject}");
        
        // Native mail wrapper or SMTP implementation
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . ($_ENV['MAIL_FROM_NAME'] ?? 'Tyche Academy') . " <" . ($_ENV['MAIL_FROM_ADDRESS'] ?? 'no-reply@tyche.academy') . ">\r\n";

        if (($_ENV['APP_ENV'] ?? 'development') === 'development') {
            return true; // Simulate successful dispatch in local dev
        }

        return @mail($to, $subject, $body, $headers);
    }
}
