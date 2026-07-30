<?php

declare(strict_types=1);

// Run via CLI: C:\xampp\php\php.exe bin/migrate_multitenant.php

$root = dirname(__DIR__);
require_once $root . '/app/Core/EnvLoader.php';
\App\Core\EnvLoader::load($root . '/.env');

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = (int)($_ENV['DB_PORT'] ?? 3306);
$dbName = $_ENV['DB_NAME'] ?? 'tyche_db';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

echo "=====================================================\n";
echo "    Tyche Multi-Tenant Migration Tool (Phase 1)      \n";
echo "=====================================================\n\n";

try {
    $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $pdo->exec("USE `{$dbName}`;");

    // 1. Create `tenants` master table if not exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `tenants` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` varchar(150) NOT NULL,
            `subdomain` varchar(100) NOT NULL,
            `email` varchar(150) NOT NULL,
            `phone` varchar(30) DEFAULT NULL,
            `status` enum('active','suspended','pending') NOT NULL DEFAULT 'active',
            `plan_name` varchar(50) NOT NULL DEFAULT 'Starter',
            `created_at` datetime NOT NULL DEFAULT current_timestamp(),
            `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            UNIQUE KEY `uk_subdomain` (`subdomain`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    echo "[✓] `tenants` master table created or verified.\n";

    // 2. Ensure Primary Default Tenant (ID 1) exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM `tenants` WHERE `id` = 1");
    if ((int)$stmt->fetchColumn() === 0) {
        $pdo->exec("
            INSERT INTO `tenants` (`id`, `name`, `subdomain`, `email`, `status`, `plan_name`)
            VALUES (1, 'Primary Academy', 'primary', 'admin@tyche.academy', 'active', 'Enterprise');
        ");
        echo "[✓] Seeded default Primary Tenant (ID 1).\n";
    }

    // 3. Complete List of all models & tables requiring tenant_id
    $tables = [
        'users',
        'leads',
        'courses',
        'admissions',
        'payments',
        'invoices',
        'batches',
        'site_settings',
        'banners',
        'pages',
        'blog_posts',
        'activity_logs',
        'login_history',
        'user_sessions',
        'system_notifications',
        'system_backups',
        'coupons',
        'marketing_campaigns',
        'job_postings',
        'job_applications'
    ];

    foreach ($tables as $table) {
        // Check if table exists
        $tableCheck = $pdo->query("SHOW TABLES LIKE '{$table}'")->fetchAll();
        if (empty($tableCheck)) {
            continue;
        }

        // Check if tenant_id column exists
        $cols = $pdo->query("SHOW COLUMNS FROM `{$table}` LIKE 'tenant_id'")->fetchAll();
        if (empty($cols)) {
            $pdo->exec("ALTER TABLE `{$table}` ADD COLUMN `tenant_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1;");
            $pdo->exec("ALTER TABLE `{$table}` ADD INDEX `idx_tenant_id` (`tenant_id`);");
            echo "[✓] Added `tenant_id` column to `{$table}` table.\n";
        } else {
            echo "[ - ] `tenant_id` already exists in `{$table}`.\n";
        }
    }

    echo "\n[✓] Multi-Tenancy Migration completed successfully!\n\n";

} catch (Exception $e) {
    echo "[X] Migration Error: " . $e->getMessage() . "\n";
    exit(1);
}
