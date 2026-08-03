<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Core\Session;

class Security
{
    public static function e(mixed $value): string
    {
        if ($value === null) {
            return '';
        }
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function sanitize(mixed $value): string
    {
        if ($value === null) {
            return '';
        }
        return trim(strip_tags((string)$value));
    }

    public static function csrfToken(): string
    {
        if (!Session::has('_csrf_token')) {
            Session::set('_csrf_token', bin2hex(random_bytes(32)));
        }
        return Session::get('_csrf_token');
    }

    public static function verifyCsrfToken(?string $token): bool
    {
        $sessionToken = Session::get('_csrf_token');
        if (!$sessionToken || !$token) {
            return false;
        }
        return hash_equals($sessionToken, $token);
    }

    public static function hashPassword(string $password): string
    {
        if (defined('PASSWORD_ARGON2ID')) {
            return password_hash($password, PASSWORD_ARGON2ID);
        }
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function generateRandomToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    public static function encryptSecret(string $plaintext): string
    {
        $key = hash('sha256', $_ENV['APP_SECRET'] ?? $_ENV['APP_NAME'] ?? 'TychePlatformSecret2026', true);
        $iv = random_bytes(16);
        $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $ciphertext);
    }

    public static function decryptSecret(string $encrypted): string
    {
        $key = hash('sha256', $_ENV['APP_SECRET'] ?? $_ENV['APP_NAME'] ?? 'TychePlatformSecret2026', true);
        $data = base64_decode($encrypted);
        if (strlen($data) < 17) {
            return '';
        }
        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);
        $decrypted = openssl_decrypt($ciphertext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return $decrypted !== false ? $decrypted : '';
    }
}
