<?php

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

use App\Core\Database;

echo "=== GURU VINDER USER RECORD ===\n";
$guru = Database::fetchOne("SELECT * FROM users WHERE email = 'guru_ids@tyche.academy'");
print_r($guru);
