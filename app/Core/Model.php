<?php

declare(strict_types=1);

namespace App\Core;

abstract class Model
{
    protected string $table;
    protected string $primaryKey = 'id';

    public function find(int|string $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        return Database::fetchOne($sql, ['id' => $id]);
    }

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC";
        return Database::fetchAll($sql);
    }

    public function findWhere(string $column, mixed $value): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :val";
        return Database::fetchAll($sql, ['val' => $value]);
    }

    public function findOneWhere(string $column, mixed $value): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :val LIMIT 1";
        return Database::fetchOne($sql, ['val' => $value]);
    }

    public function create(array $data): string|false
    {
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
        $sql = "UPDATE {$this->table} SET {$fields} WHERE {$this->primaryKey} = :pk_id";

        $data['pk_id'] = $id;
        return Database::execute($sql, $data);
    }

    public function delete(int|string $id): int
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        return Database::execute($sql, ['id' => $id]);
    }
}
