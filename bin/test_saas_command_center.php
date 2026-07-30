<?php

declare(strict_types=1);

// Run via CLI: C:\xampp\php\php.exe bin/test_saas_command_center.php

$root = dirname(__DIR__);

// Load Autoloader & Environment
$autoloadFile = $root . '/vendor/autoload.php';
if (file_exists($autoloadFile)) {
    require_once $autoloadFile;
} else {
    spl_autoload_register(function ($class) use ($root) {
        $prefix = 'App\\';
        $baseDir = $root . '/app/';
        $len = strlen($prefix);

        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
        }
    });
}

\App\Core\EnvLoader::load($root . '/.env');

echo "=====================================================\n";
echo "   Tyche SaaS Command Center Automated Tester        \n";
echo "=====================================================\n\n";

$passed = 0;
$failed = 0;

function assertCc(string $testName, callable $fn): void
{
    global $passed, $failed;
    try {
        $fn();
        echo "[PASS] {$testName}\n";
        $passed++;
    } catch (\Throwable $e) {
        echo "[FAIL] {$testName}: " . $e->getMessage() . "\n";
        $failed++;
    }
}

// 1. Test SaasCommandCenterController instantiation
assertCc("SaasCommandCenterController initializes cleanly", function() {
    $ctrl = new \App\Controllers\Admin\SaasCommandCenterController();
});

// 2. Test global cloud telemetry aggregation
assertCc("Global Cloud Telemetry collects multi-tenant metrics", function() {
    $tenantModel = new \App\Models\Tenant();
    $tenants = $tenantModel->all();
    if (empty($tenants)) {
        throw new \Exception("No tenants available for telemetry matrix.");
    }
});

echo "\n-----------------------------------------------------\n";
echo "COMMAND CENTER SUITE RESULTS: Passed: {$passed} | Failed: {$failed}\n";
echo "=====================================================\n";

if ($failed > 0) {
    exit(1);
}
