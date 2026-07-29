<?php

declare(strict_types=1);

// Run from CLI: C:\xampp\php\php.exe bin/migrate_crm.php

$root = dirname(__DIR__);
require_once $root . '/app/Core/EnvLoader.php';
\App\Core\EnvLoader::load($root . '/.env');

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = $_ENV['DB_PORT'] ?? 3306;
$dbName = $_ENV['DB_NAME'] ?? 'tyche_db';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

echo "=== Tyche Enterprise CRM & Admissions Database Migration ===\n";

try {
    $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $pdo->exec("USE `{$dbName}`;");

    // 1. Upgrade `leads` table status column and add lifecycle fields
    $pdo->exec("ALTER TABLE `leads` MODIFY COLUMN `status` ENUM('new','contacted','qualified','nurturing','application_sent','payment_link_generated','payment_received','enrolled','lost') DEFAULT 'new';");
    echo "[✓] Updated `leads.status` ENUM to lifecycle stages.\n";

    // Add lost_reason if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM `leads` LIKE 'lost_reason'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `leads` ADD COLUMN `lost_reason` ENUM('no_response','not_interested','budget_issue','joined_elsewhere','course_mismatch','other') NULL AFTER `status`;");
        echo "[✓] Added `lost_reason` column to `leads` table.\n";
    }

    // Add lost_notes if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM `leads` LIKE 'lost_notes'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `leads` ADD COLUMN `lost_notes` TEXT NULL AFTER `lost_reason`;");
        echo "[✓] Added `lost_notes` column to `leads` table.\n";
    }

    // Add batch_id if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM `leads` LIKE 'batch_id'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `leads` ADD COLUMN `batch_id` BIGINT UNSIGNED NULL AFTER `course_id`;");
        echo "[✓] Added `batch_id` column to `leads` table.\n";
    }

    // Add sla_due_at if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM `leads` LIKE 'sla_due_at'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `leads` ADD COLUMN `sla_due_at` DATETIME NULL AFTER `lead_score`;");
        echo "[✓] Added `sla_due_at` column to `leads` table.\n";
    }

    // Add is_sla_breached if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM `leads` LIKE 'is_sla_breached'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `leads` ADD COLUMN `is_sla_breached` TINYINT(1) NOT NULL DEFAULT 0 AFTER `sla_due_at`;");
        echo "[✓] Added `is_sla_breached` column to `leads` table.\n";
    }

    // Add last_interaction_at if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM `leads` LIKE 'last_interaction_at'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `leads` ADD COLUMN `last_interaction_at` DATETIME NULL AFTER `is_sla_breached`;");
        echo "[✓] Added `last_interaction_at` column to `leads` table.\n";
    }

    // Add reactivated_at if not exists
    $cols = $pdo->query("SHOW COLUMNS FROM `leads` LIKE 'reactivated_at'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `leads` ADD COLUMN `reactivated_at` DATETIME NULL AFTER `last_interaction_at`;");
        echo "[✓] Added `reactivated_at` column to `leads` table.\n";
    }

    // 2. Create `lead_activities` table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `lead_activities` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `lead_id` BIGINT UNSIGNED NOT NULL,
        `user_id` BIGINT UNSIGNED NULL,
        `type` ENUM('call','whatsapp','email','note','stage_change','payment_link','import','duplicate_hit') NOT NULL,
        `outcome` ENUM('connected','rnr','switched_off','busy','sent','delivered','read','replied','converted','lost','reactivated','duplicate_recorded') NULL,
        `notes` TEXT NULL,
        `duration_seconds` INT NULL,
        `metadata_json` JSON NULL,
        `created_at` DATETIME NOT NULL,
        INDEX (`lead_id`),
        INDEX (`user_id`),
        INDEX (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "[✓] Ensured `lead_activities` table exists.\n";

    // 3. Create `batches` table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `batches` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `course_id` BIGINT UNSIGNED NOT NULL,
        `batch_name` VARCHAR(100) NOT NULL,
        `start_date` DATE NOT NULL,
        `end_date` DATE NULL,
        `schedule_type` ENUM('weekend','weekday','evening') DEFAULT 'weekend',
        `capacity` INT NOT NULL DEFAULT 30,
        `seats_filled` INT NOT NULL DEFAULT 0,
        `status` ENUM('upcoming','active','completed','full') DEFAULT 'upcoming',
        `created_at` DATETIME NOT NULL,
        INDEX (`course_id`),
        INDEX (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "[✓] Ensured `batches` table exists.\n";

    // 4. Create `payment_links` table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `payment_links` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `link_code` VARCHAR(100) NOT NULL UNIQUE,
        `lead_id` BIGINT UNSIGNED NOT NULL,
        `course_id` BIGINT UNSIGNED NOT NULL,
        `batch_id` BIGINT UNSIGNED NULL,
        `amount` DECIMAL(10,2) NOT NULL,
        `gateway` ENUM('razorpay','cashfree','payu','stripe','upi') DEFAULT 'razorpay',
        `gateway_link_id` VARCHAR(150) NULL,
        `payment_url` VARCHAR(255) NULL,
        `expires_at` DATETIME NOT NULL,
        `status` ENUM('active','paid','expired','failed') DEFAULT 'active',
        `paid_at` DATETIME NULL,
        `created_at` DATETIME NOT NULL,
        INDEX (`lead_id`),
        INDEX (`link_code`),
        INDEX (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "[✓] Ensured `payment_links` table exists.\n";

    // 5. Seed default batch if none exists
    $existingBatches = $pdo->query("SELECT COUNT(*) FROM `batches`")->fetchColumn();
    if ((int)$existingBatches === 0) {
        $courses = $pdo->query("SELECT id, title FROM `courses` LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($courses as $c) {
            $pdo->exec("INSERT INTO `batches` (`course_id`, `batch_name`, `start_date`, `end_date`, `schedule_type`, `capacity`, `seats_filled`, `status`, `created_at`) VALUES (
                {$c['id']},
                '{$c['title']} - Cohort Alpha 2026',
                '".date('Y-m-d', strtotime('+7 days'))."',
                '".date('Y-m-d', strtotime('+67 days'))."',
                'weekend',
                25,
                3,
                'active',
                '".date('Y-m-d H:i:s')."'
            )");
        }
        echo "[✓] Seeded default initial batches for courses.\n";
    }

    echo "=== CRM Migration Completed Successfully ===\n";

} catch (Exception $e) {
    echo "[X] Migration Error: " . $e->getMessage() . "\n";
    exit(1);
}
