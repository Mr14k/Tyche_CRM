<?php
$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

echo "=== LEAD_ACTIVITIES ===\n";
print_r(array_column(\App\Core\Database::fetchAll("DESCRIBE lead_activities"), 'Field'));
