<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class User extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        // Search globally across tenants for authentication since email is unique
        $sql = "SELECT * FROM users WHERE email = :val LIMIT 1";
        return Database::fetchOne($sql, ['val' => strtolower(trim($email))]);
    }

    public function getRoles(int $userId): array
    {
        $sql = "SELECT r.* FROM roles r 
                JOIN user_roles ur ON r.id = ur.role_id 
                WHERE ur.user_id = :user_id";
        return Database::fetchAll($sql, ['user_id' => $userId]);
    }

    public function getPermissions(int $userId): array
    {
        $sql = "SELECT DISTINCT p.code FROM permissions p
                JOIN role_permissions rp ON p.id = rp.permission_id
                JOIN user_roles ur ON rp.role_id = ur.role_id
                WHERE ur.user_id = :user_id";
        $results = Database::fetchAll($sql, ['user_id' => $userId]);
        return array_column($results, 'code');
    }

    public function assignRole(int $userId, int $roleId): void
    {
        $sql = "INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)";
        Database::execute($sql, ['user_id' => $userId, 'role_id' => $roleId]);
    }

    public function syncRoles(int $userId, array $roleIds): void
    {
        Database::execute("DELETE FROM user_roles WHERE user_id = :user_id", ['user_id' => $userId]);
        foreach ($roleIds as $rId) {
            $this->assignRole($userId, (int)$rId);
        }
    }
}
