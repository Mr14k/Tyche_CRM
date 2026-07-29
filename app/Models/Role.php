<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Role extends Model
{
    protected string $table = 'roles';

    public function getPermissions(int $roleId): array
    {
        $sql = "SELECT p.* FROM permissions p 
                JOIN role_permissions rp ON p.id = rp.permission_id 
                WHERE rp.role_id = :role_id";
        return Database::fetchAll($sql, ['role_id' => $roleId]);
    }

    public function syncPermissions(int $roleId, array $permissionIds): void
    {
        Database::execute("DELETE FROM role_permissions WHERE role_id = :role_id", ['role_id' => $roleId]);
        foreach ($permissionIds as $pId) {
            $sql = "INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)";
            Database::execute($sql, ['role_id' => $roleId, 'permission_id' => (int)$pId]);
        }
    }
}
