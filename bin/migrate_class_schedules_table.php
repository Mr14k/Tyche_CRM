<?php

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

use App\Core\Database;

echo "Migrating class_schedules table...\n";

$sql = "CREATE TABLE IF NOT EXISTS class_schedules (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    tenant_id INT NOT NULL,
    course_id INT NOT NULL,
    batch_id INT NULL,
    faculty_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    schedule_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    meeting_provider VARCHAR(50) NOT NULL DEFAULT 'jitsi',
    meeting_link VARCHAR(500) NULL,
    status ENUM('scheduled', 'live', 'completed', 'cancelled') NOT NULL DEFAULT 'scheduled',
    created_by_role ENUM('admin', 'faculty') NOT NULL DEFAULT 'faculty',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_tenant_faculty_date (tenant_id, faculty_id, schedule_date),
    INDEX idx_tenant_batch (tenant_id, batch_id),
    INDEX idx_tenant_status (tenant_id, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

Database::execute($sql);

echo "[PASS] Table class_schedules created successfully!\n";
