<?php

declare(strict_types=1);

// Run via CLI: C:\xampp\php\php.exe bin/migrate_subscriptions.php

$root = dirname(__DIR__);
require_once $root . '/app/Core/EnvLoader.php';
\App\Core\EnvLoader::load($root . '/.env');

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = (int)($_ENV['DB_PORT'] ?? 3306);
$dbName = $_ENV['DB_NAME'] ?? 'tyche_db';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

echo "=====================================================\n";
echo "    Tyche SaaS Subscription Manager Migration Tool   \n";
echo "=====================================================\n\n";

try {
    $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $pdo->exec("USE `{$dbName}`;");

    // 1. Create `subscription_plans` table if not exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `subscription_plans` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `plan_key` varchar(50) NOT NULL,
            `name` varchar(100) NOT NULL,
            `price` decimal(10,2) NOT NULL DEFAULT 0.00,
            `billing_cycle` enum('monthly','annual') NOT NULL DEFAULT 'monthly',
            `max_leads` int(11) NOT NULL DEFAULT 100,
            `max_courses` int(11) NOT NULL DEFAULT 5,
            `max_students` int(11) NOT NULL DEFAULT 100,
            `modules` text DEFAULT NULL,
            `is_active` tinyint(1) NOT NULL DEFAULT 1,
            `created_at` datetime NOT NULL DEFAULT current_timestamp(),
            `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            UNIQUE KEY `uk_plan_key` (`plan_key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    echo "[✓] `subscription_plans` table created or verified.\n";

    // Seed default plans if empty
    $planCount = (int)$pdo->query("SELECT COUNT(*) FROM `subscription_plans`")->fetchColumn();
    if ($planCount === 0) {
        $defaultPlans = [
            [
                'plan_key' => 'Bronze',
                'name' => 'Bronze Class',
                'price' => 2999.00,
                'billing_cycle' => 'monthly',
                'max_leads' => 100,
                'max_courses' => 5,
                'max_students' => 100,
                'modules' => json_encode(['crm', 'lms'])
            ],
            [
                'plan_key' => 'Silver',
                'name' => 'Silver Class',
                'price' => 7999.00,
                'billing_cycle' => 'monthly',
                'max_leads' => 1000,
                'max_courses' => 25,
                'max_students' => 1000,
                'modules' => json_encode(['crm', 'lms', 'bi', 'finance'])
            ],
            [
                'plan_key' => 'Gold',
                'name' => 'Gold Class',
                'price' => 14999.00,
                'billing_cycle' => 'monthly',
                'max_leads' => 10000,
                'max_courses' => 100,
                'max_students' => 10000,
                'modules' => json_encode(['crm', 'lms', 'bi', 'finance', 'placement', 'automation'])
            ],
            [
                'plan_key' => 'Enterprise',
                'name' => 'Enterprise Class',
                'price' => 29999.00,
                'billing_cycle' => 'monthly',
                'max_leads' => -1,
                'max_courses' => -1,
                'max_students' => -1,
                'modules' => json_encode(['crm', 'lms', 'bi', 'finance', 'placement', 'automation', 'whitelabel'])
            ]
        ];

        $stmt = $pdo->prepare("
            INSERT INTO `subscription_plans` (`plan_key`, `name`, `price`, `billing_cycle`, `max_leads`, `max_courses`, `max_students`, `modules`)
            VALUES (:plan_key, :name, :price, :billing_cycle, :max_leads, :max_courses, :max_students, :modules)
        ");

        foreach ($defaultPlans as $p) {
            $stmt->execute($p);
        }
        echo "[✓] Seeded default subscription plans (Bronze, Silver, Gold, Enterprise).\n";
    }

    // 2. Add `subscription_expires_at` column to `tenants` table if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM `tenants` LIKE 'subscription_expires_at'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `tenants` ADD COLUMN `subscription_expires_at` datetime DEFAULT NULL AFTER `plan_name`;");
        echo "[✓] Added `subscription_expires_at` column to `tenants` table.\n";
    } else {
        echo "[ - ] `subscription_expires_at` column already exists in `tenants`.\n";
    }

    // Update existing tenants with 30-day subscription expiration date if null
    $expiryDate = date('Y-m-d H:i:s', strtotime('+30 days'));
    $pdo->exec("UPDATE `tenants` SET `subscription_expires_at` = '{$expiryDate}' WHERE `subscription_expires_at` IS NULL;");
    echo "[✓] Updated existing tenants with 30-day default renewal date.\n\n";

} catch (Exception $e) {
    echo "[X] Migration Error: " . $e->getMessage() . "\n";
    exit(1);
}
