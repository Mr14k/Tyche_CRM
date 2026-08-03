<?php

declare(strict_types=1);

namespace App\Helpers;

class Url
{
    public static function base(string $path = ''): string
    {
        $baseUrl = $_ENV['APP_URL'] ?? 'http://localhost/tyche';
        $subfolder = '';
        
        // Auto-detect base path if running under Apache/XAMPP subfolder
        if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['SCRIPT_NAME'])) {
            $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
            $subfolder = rtrim(str_replace('/public', '', $scriptDir), '/');
            $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $baseUrl = $scheme . '://' . $host . $subfolder;
        }

        $baseUrl = rtrim($baseUrl, '/');
        $path = ltrim($path, '/');

        // Strip subfolder prefix if path already includes it to prevent /tyche/tyche/ URL duplication
        if (!empty($subfolder)) {
            $subName = ltrim($subfolder, '/');
            if (!empty($subName) && str_starts_with($path, $subName . '/')) {
                $path = substr($path, strlen($subName) + 1);
            }
        }

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
