<?php

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

use App\Core\Database;

echo "=== ALL BATCHES ===\n";
$batches = Database::fetchAll("SELECT b.*, c.title as course_title FROM batches b LEFT JOIN courses c ON b.course_id = c.id");
print_r($batches);

echo "=== ALL COURSES ===\n";
$courses = Database::fetchAll("SELECT id, title, code, tenant_id FROM courses");
print_r($courses);
