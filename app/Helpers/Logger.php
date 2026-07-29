<?php

declare(strict_types=1);

namespace App\Helpers;

class Logger
{
    public static function log(string $level, string $message, array $context = []): void
    {
        $logDir = dirname(__DIR__, 2) . '/storage/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $filename = $logDir . '/app-' . date('Y-m-d') . '.log';
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context, JSON_UNESCAPED_SLASHES) : '';
        $logEntry = sprintf("[%s] %s: %s%s\n", $timestamp, strtoupper($level), $message, $contextStr);

        file_put_contents($filename, $logEntry, FILE_APPEND | LOCK_EX);
    }

    public static function info(string $message, array $context = []): void
    {
        self::log('INFO', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::log('ERROR', $message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::log('WARNING', $message, $context);
    }

    public static function security(string $message, array $context = []): void
    {
        self::log('SECURITY', $message, $context);
    }
}
