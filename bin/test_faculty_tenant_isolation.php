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

echo "Testing Faculty Tenant Isolation Container for Guru Vinder (Tenant 3)...\n";

// Simulate Guru Vinder logged in session
Session::set('user', [
    'id' => 21,
    'first_name' => 'Guru',
    'last_name' => 'Vinder',
    'email' => 'guru_ids@tyche.academy',
    'tenant_id' => 3
]);
Session::set('tenant_id', 3);

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/faculty/schedules';

// Execute TenantMiddleware to set context
$middleware = new \App\Middlewares\TenantMiddleware();
$request = new \App\Core\Request();

$middleware->handle($request, function($req) {
    $controller = new FacultyScheduleController();
    
    ob_start();
    $controller->index($req);
    $html = ob_get_clean();

    $tid = TenantContext::getTenantId();
    echo "Active Context Tenant ID: {$tid}\n";

    // Verify batches in HTML
    if ($tid === 3 && str_contains($html, 'DMS_IDS_1') && !str_contains($html, 'Programmatic Advertising & DV360 - Cohort Alpha 2026')) {
        echo "[PASS] Faculty workspace is strictly containerized to Tenant 3! Only tenant 3 batches (DMS_IDS_1) rendered!\n";
        exit(0);
    } else {
        echo "[FAIL] Tenant isolation breach detected! Rendered batches from other tenants.\n";
        exit(1);
    }
});
