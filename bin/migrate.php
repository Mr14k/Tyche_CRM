<?php

declare(strict_types=1);

// Run from CLI: C:\xampp\php\php.exe bin/migrate.php

$root = dirname(__DIR__);
require_once $root . '/app/Core/EnvLoader.php';
\App\Core\EnvLoader::load($root . '/.env');

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = $_ENV['DB_PORT'] ?? 3306;
$dbName = $_ENV['DB_NAME'] ?? 'tyche_db';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

echo "=== Tyche Database Migration Tool (Self-Service Payments Upgrade) ===\n";

try {
    $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $pdo->exec("USE `{$dbName}`;");

    // 1. Add highlights_json to courses if not exists
    $columns = $pdo->query("SHOW COLUMNS FROM `courses` LIKE 'highlights_json'")->fetchAll();
    if (empty($columns)) {
        $pdo->exec("ALTER TABLE `courses` ADD COLUMN `highlights_json` JSON NULL AFTER `allow_skip_lessons`;");
        echo "[✓] Added `highlights_json` column to `courses` table.\n";
    }

    // 2. Make admission_id in payments nullable
    $pdo->exec("ALTER TABLE `payments` MODIFY COLUMN `admission_id` BIGINT UNSIGNED NULL;");
    echo "[✓] Updated `payments.admission_id` to NULLABLE.\n";

    // 3. Add user_id to payments if not exists
    $userCols = $pdo->query("SHOW COLUMNS FROM `payments` LIKE 'user_id'")->fetchAll();
    if (empty($userCols)) {
        $pdo->exec("ALTER TABLE `payments` ADD COLUMN `user_id` BIGINT UNSIGNED NULL AFTER `payment_reference`;");
        echo "[✓] Added `user_id` column to `payments` table.\n";
    }

    // 4. Add course_id to payments if not exists
    $courseCols = $pdo->query("SHOW COLUMNS FROM `payments` LIKE 'course_id'")->fetchAll();
    if (empty($courseCols)) {
        $pdo->exec("ALTER TABLE `payments` ADD COLUMN `course_id` BIGINT UNSIGNED NULL AFTER `user_id`;");
        echo "[✓] Added `course_id` column to `payments` table.\n";
    }

    echo "[✓] Self-Service Payments database schema upgraded successfully.\n";

} catch (Exception $e) {
    echo "[X] Migration Error: " . $e->getMessage() . "\n";
    exit(1);
}
