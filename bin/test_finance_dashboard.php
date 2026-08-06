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
use App\Controllers\Admin\Finance\PaymentController;

echo "Testing Executive Financial BI Dashboard (/admin/finance/dashboard)...\n";

TenantContext::setTenantId(1);
Session::set('user', [
    'id' => 1,
    'first_name' => 'Admin',
    'last_name' => 'User',
    'email' => 'admin@tyche.academy',
    'tenant_id' => 1
]);

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/finance/dashboard';

try {
    $controller = new PaymentController();
    $request = new \App\Core\Request();
    
    ob_start();
    $controller->dashboard($request);
    $html = ob_get_clean();

    echo "HTML View Length: " . strlen($html) . " bytes\n";
    if (str_contains($html, 'Executive Financial BI & Fee Recovery Hub') && str_contains($html, 'Month-to-Date (MTD)') && str_contains($html, 'Statutory 18% GST Tax Audit Ledger')) {
        echo "[PASS] Executive Financial BI Dashboard rendered successfully!\n";
        exit(0);
    } else {
        echo "[FAIL] Financial Dashboard rendered unexpected HTML.\n";
        exit(1);
    }
} catch (\Throwable $e) {
    echo "[FAIL] Exception caught: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
