<?php
$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

echo "Migrating site_settings table to composite primary key (tenant_id, setting_key)...\n";
try {
    \App\Core\Database::execute("ALTER TABLE site_settings DROP PRIMARY KEY, ADD PRIMARY KEY (tenant_id, setting_key)");
    echo "MIGRATION SUCCESSFUL!\n";
} catch (\Throwable $e) {
    echo "Migration Note: " . $e->getMessage() . "\n";
}
