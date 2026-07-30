<?php

declare(strict_types=1);

// Run via CLI: C:\xampp\php\php.exe bin/update_tenant_controls.php

$root = dirname(__DIR__);
require_once $root . '/app/Core/EnvLoader.php';
\App\Core\EnvLoader::load($root . '/.env');

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = (int)($_ENV['DB_PORT'] ?? 3306);
$dbName = $_ENV['DB_NAME'] ?? 'tyche_db';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

echo "=====================================================\n";
echo "   Tyche SaaS Admin Control Migration Script         \n";
echo "=====================================================\n\n";

try {
    $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $pdo->exec("USE `{$dbName}`;");

    // Add `modules` column to `tenants` table if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM `tenants` LIKE 'modules'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `tenants` ADD COLUMN `modules` text DEFAULT NULL AFTER `plan_name`;");
        echo "[✓] Added `modules` column to `tenants` table.\n";
    } else {
        echo "[ - ] `modules` column already exists in `tenants`.\n";
    }

    // Set default modules for existing tenants
    $defaultModules = json_encode(['crm', 'lms', 'bi', 'finance', 'placement', 'automation']);
    $pdo->exec("UPDATE `tenants` SET `modules` = '{$defaultModules}' WHERE `modules` IS NULL OR `modules` = '';");
    echo "[✓] Updated existing tenants with default module permissions.\n\n";

} catch (Exception $e) {
    echo "[X] Migration Error: " . $e->getMessage() . "\n";
    exit(1);
}
