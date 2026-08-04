<?php

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

use App\Core\TenantContext;
use App\Core\Session;
use App\Controllers\Faculty\FacultyScheduleController;

echo "Testing Faculty Timetable Page Execution (/faculty/schedules)...\n";

TenantContext::setTenantId(3);
Session::set('user', [
    'id' => 21,
    'first_name' => 'Guru',
    'last_name' => 'Vinder',
    'email' => 'guru_ids@tyche.academy',
    'tenant_id' => 3
]);

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/faculty/schedules';

try {
    $controller = new FacultyScheduleController();
    $request = new \App\Core\Request();
    
    ob_start();
    $controller->index($request);
    $html = ob_get_clean();

    echo "HTML View Length: " . strlen($html) . " bytes\n";
    if (strlen($html) > 1000 && str_contains($html, 'Class Timetable & Digital Rooms')) {
        echo "[PASS] Faculty Timetable page rendered successfully!\n";
        exit(0);
    } else {
        echo "[FAIL] Faculty Timetable rendered unexpected HTML.\n";
        exit(1);
    }
} catch (\Throwable $e) {
    echo "[FAIL] Exception caught: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
