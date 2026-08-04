<?php

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

use App\Core\Database;

echo "Backfilling course_instructors from class_schedules...\n";

$schedules = Database::fetchAll("SELECT DISTINCT tenant_id, course_id, faculty_id FROM class_schedules WHERE faculty_id IS NOT NULL AND faculty_id > 0");

$added = 0;
foreach ($schedules as $s) {
    $exists = Database::fetchOne(
        "SELECT 1 FROM course_instructors WHERE tenant_id = :tid AND course_id = :cid AND user_id = :fid LIMIT 1",
        ['tid' => $s['tenant_id'], 'cid' => $s['course_id'], 'fid' => $s['faculty_id']]
    );

    if (!$exists) {
        Database::execute(
            "INSERT INTO course_instructors (tenant_id, course_id, user_id, role) VALUES (:tid, :cid, :fid, 'instructor')",
            ['tid' => $s['tenant_id'], 'cid' => $s['course_id'], 'fid' => $s['faculty_id']]
        );
        $added++;
    }
}

echo "[SUCCESS] Backfilled {$added} missing course instructor linkages!\n";
