<?php

declare(strict_types=1);

// Run via CLI: C:\xampp\php\php.exe bin/migrate_all_tenant_tables.php

$root = dirname(__DIR__);
require_once $root . '/app/Core/EnvLoader.php';
\App\Core\EnvLoader::load($root . '/.env');

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = (int)($_ENV['DB_PORT'] ?? 3306);
$dbName = $_ENV['DB_NAME'] ?? 'tyche_db';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

echo "=====================================================\n";
echo "    Tyche Full Multi-Tenant Schema Auditor & Fixer   \n";
echo "=====================================================\n\n";

try {
    $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $pdo->exec("USE `{$dbName}`;");

    // Master tables that should NOT be scoped by tenant_id (Global System Tables)
    $globalTables = ['tenants', 'roles', 'permissions', 'role_permissions', 'user_roles'];

    // Get all tables in database
    $allTables = $pdo->query("SHOW TABLES;")->fetchAll(PDO::FETCH_COLUMN);

    $addedCount = 0;
    foreach ($allTables as $table) {
        if (in_array($table, $globalTables, true)) {
            continue;
        }

        // Check if tenant_id column exists
        $cols = $pdo->query("SHOW COLUMNS FROM `{$table}` LIKE 'tenant_id'")->fetchAll();
        if (empty($cols)) {
            $pdo->exec("ALTER TABLE `{$table}` ADD COLUMN `tenant_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1;");
            $pdo->exec("ALTER TABLE `{$table}` ADD INDEX `idx_tenant_id` (`tenant_id`);");
            echo "[✓] Added `tenant_id` column to `{$table}` table.\n";
            $addedCount++;
        }
    }

    echo "\n[✓] Audit Complete! Added `tenant_id` to {$addedCount} domain tables.\n\n";

} catch (Exception $e) {
    echo "[X] Migration Error: " . $e->getMessage() . "\n";
    exit(1);
}
