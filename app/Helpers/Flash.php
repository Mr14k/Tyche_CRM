<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Core\Session;

class Flash
{
    public static function set(string $type, string $message): void
    {
        $flashes = Session::get('_flash_messages', []);
        $flashes[] = ['type' => $type, 'message' => $message];
        Session::set('_flash_messages', $flashes);
    }

    public static function success(string $message): void
    {
        self::set('success', $message);
    }

    public static function error(string $message): void
    {
        self::set('danger', $message);
    }

    public static function info(string $message): void
    {
        self::set('info', $message);
    }

    public static function has(?string $type = null): bool
    {
        $flashes = Session::get('_flash_messages', []);
        if (empty($flashes)) {
            return false;
        }
        if ($type === null) {
            return true;
        }
        foreach ($flashes as $f) {
            if (isset($f['type']) && ($f['type'] === $type || ($type === 'error' && $f['type'] === 'danger'))) {
                return true;
            }
        }
        return false;
    }

    public static function get(?string $type = null): mixed
    {
        $flashes = Session::get('_flash_messages', []);
        if ($type === null) {
            Session::remove('_flash_messages');
            return $flashes;
        }
        $matching = [];
        $remaining = [];
        foreach ($flashes as $f) {
            if (isset($f['type']) && ($f['type'] === $type || ($type === 'error' && $f['type'] === 'danger'))) {
                $matching[] = $f['message'];
            } else {
                $remaining[] = $f;
            }
        }
        Session::set('_flash_messages', $remaining);
        return !empty($matching) ? implode(', ', $matching) : null;
    }

    public static function render(): string
    {
        $flashes = self::get();
        if (empty($flashes) || !is_array($flashes)) {
            return '';
        }

        $html = '<div class="flash-container mb-3">';
        foreach ($flashes as $f) {
            $type = Security::e($f['type'] ?? 'info');
            $msg = Security::e($f['message'] ?? '');
            $html .= "<div class=\"alert alert-{$type} alert-dismissible fade show\" role=\"alert\">
                        {$msg}
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                    </div>";
        }
        $html .= '</div>';
        return $html;
    }
}
