<?php

declare(strict_types=1);

namespace App\Core;

abstract class Model
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected bool $tenantScoped = true;

    public function find(int|string $id): ?array
    {
        if ($this->tenantScoped) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id AND tenant_id = :tenant_id LIMIT 1";
            return Database::fetchOne($sql, ['id' => $id, 'tenant_id' => TenantContext::getTenantId()]);
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        return Database::fetchOne($sql, ['id' => $id]);
    }

    public function all(): array
    {
        if ($this->tenantScoped) {
            $sql = "SELECT * FROM {$this->table} WHERE tenant_id = :tenant_id ORDER BY {$this->primaryKey} DESC";
            return Database::fetchAll($sql, ['tenant_id' => TenantContext::getTenantId()]);
        }

        $sql = "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC";
        return Database::fetchAll($sql);
    }

    public function findWhere(string $column, mixed $value): array
    {
        if ($this->tenantScoped) {
            $sql = "SELECT * FROM {$this->table} WHERE {$column} = :val AND tenant_id = :tenant_id";
            return Database::fetchAll($sql, ['val' => $value, 'tenant_id' => TenantContext::getTenantId()]);
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :val";
        return Database::fetchAll($sql, ['val' => $value]);
    }

    public function findOneWhere(string $column, mixed $value): ?array
    {
        if ($this->tenantScoped) {
            $sql = "SELECT * FROM {$this->table} WHERE {$column} = :val AND tenant_id = :tenant_id LIMIT 1";
            return Database::fetchOne($sql, ['val' => $value, 'tenant_id' => TenantContext::getTenantId()]);
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :val LIMIT 1";
        return Database::fetchOne($sql, ['val' => $value]);
    }

    public function create(array $data): string|false
    {
        if ($this->tenantScoped && !array_key_exists('tenant_id', $data)) {
            $data['tenant_id'] = TenantContext::getTenantId();
        }

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        return Database::insert($sql, $data);
    }

    public function update(int|string $id, array $data): int
    {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= "{$key} = :{$key}, ";
        }
        $fields = rtrim($fields, ', ');

        if ($this->tenantScoped) {
            $sql = "UPDATE {$this->table} SET {$fields} WHERE {$this->primaryKey} = :pk_id AND tenant_id = :tenant_id";
            $data['pk_id'] = $id;
            $data['tenant_id'] = TenantContext::getTenantId();
            return Database::execute($sql, $data);
        }

        $sql = "UPDATE {$this->table} SET {$fields} WHERE {$this->primaryKey} = :pk_id";
        $data['pk_id'] = $id;
        return Database::execute($sql, $data);
    }

    public function delete(int|string $id): int
    {
        if ($this->tenantScoped) {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id AND tenant_id = :tenant_id";
            return Database::execute($sql, ['id' => $id, 'tenant_id' => TenantContext::getTenantId()]);
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        return Database::execute($sql, ['id' => $id]);
    }
}
