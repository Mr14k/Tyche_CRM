<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Session;

class RbacService extends Service
{
    public static function hasRole(string $role): bool
    {
        $user = Session::get('user');
        if (!$user || !isset($user['roles'])) {
            return false;
        }

        if (in_array('Super Admin', $user['roles'], true) || in_array('super_admin', $user['roles'], true)) {
            return true;
        }

        return in_array($role, $user['roles'], true);
    }

    public static function hasPermission(string $permissionCode): bool
    {
        $user = Session::get('user');
        if (!$user || !isset($user['permissions'])) {
            return false;
        }

        if (in_array('Super Admin', $user['roles'] ?? [], true) || in_array('super_admin', $user['roles'] ?? [], true)) {
            return true;
        }

        return in_array($permissionCode, $user['permissions'], true);
    }
}
