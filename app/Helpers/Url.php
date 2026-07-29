<?php

declare(strict_types=1);

namespace App\Helpers;

class Url
{
    public static function base(string $path = ''): string
    {
        $baseUrl = rtrim($_ENV['APP_URL'] ?? 'http://localhost/tyche', '/');
        return $baseUrl . '/' . ltrim($path, '/');
    }

    public static function to(string $path = ''): string
    {
        return self::base($path);
    }

    public static function asset(string $path): string
    {
        return self::base('public/assets/' . ltrim($path, '/'));
    }

    public static function upload(string $path): string
    {
        return self::base('storage/uploads/' . ltrim($path, '/'));
    }
}
