<?php

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

use App\Core\Database;

echo "Fixing course_categories slug index for multi-tenancy...\n";

try {
    // Drop old global unique index on slug if exists
    Database::execute("ALTER TABLE course_categories DROP INDEX slug");
    echo "[PASS] Dropped global UNIQUE index 'slug'.\n";
} catch (\Throwable $e) {
    echo "[NOTE] Index 'slug' already dropped or does not exist.\n";
}

try {
    // Add per-tenant composite unique key (tenant_id, slug)
    Database::execute("ALTER TABLE course_categories ADD UNIQUE KEY idx_tenant_slug (tenant_id, slug)");
    echo "[PASS] Created composite UNIQUE KEY 'idx_tenant_slug (tenant_id, slug)'.\n";
} catch (\Throwable $e) {
    echo "[NOTE] Composite key 'idx_tenant_slug' already exists.\n";
}

echo "[SUCCESS] Database migration completed!\n";
