<?php

declare(strict_types=1);

/**
 * Migration Script: Create tenant_ad_connections Table
 */

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

echo "Creating tenant_ad_connections table for Meta Ads & Google Ads Ingestion...\n";

$sql = "CREATE TABLE IF NOT EXISTS tenant_ad_connections (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tenant_id BIGINT UNSIGNED NOT NULL,
    platform ENUM('meta','google') NOT NULL,
    page_or_account_id VARCHAR(255) NOT NULL,
    access_token_encrypted TEXT NOT NULL,
    refresh_token_encrypted TEXT NULL,
    webhook_secret_encrypted TEXT NULL,
    token_expires_at DATETIME NULL,
    status ENUM('active','expired','revoked') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY tenant_platform_page (tenant_id, platform, page_or_account_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    \App\Core\Database::execute($sql);
    echo "MIGRATION SUCCESSFUL: tenant_ad_connections table is ready!\n";
} catch (\Throwable $e) {
    echo "Migration Note: " . $e->getMessage() . "\n";
}
