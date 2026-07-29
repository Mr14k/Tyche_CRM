<?php

declare(strict_types=1);

// Run from CLI: C:\xampp\php\php.exe bin/test-runner.php

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
date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Asia/Kolkata');

echo "=====================================================\n";
echo "    TYCHE ACADEMY AUTOMATED ARCHITECTURE TESTER      \n";
echo "    (Complete Monolith Phases 0 - 14 Final Suite)    \n";
echo "=====================================================\n\n";

$passed = 0;
$failed = 0;

function assertTest(string $description, bool $condition): void
{
    global $passed, $failed;
    if ($condition) {
        echo "[PASS] {$description}\n";
        $passed++;
    } else {
        echo "[FAIL] {$description}\n";
        $failed++;
    }
}

// ----------------------------------------------------
// 1. Test Database Singleton Connection & Tables
// ----------------------------------------------------
try {
    $pdo = \App\Core\Database::getInstance();
    assertTest("Database Singleton connection returned valid PDO instance", $pdo instanceof PDO);

    $tables = \App\Core\Database::fetchAll("SHOW TABLES;");
    assertTest("Database contains seeded tables (Count >= 58)", count($tables) >= 58);
} catch (\Exception $e) {
    assertTest("Database test failed: " . $e->getMessage(), false);
}

// ----------------------------------------------------
// 2. Test Security & Password Hashing
// ----------------------------------------------------
$password = "SecretPass123!";
$hash = \App\Helpers\Security::hashPassword($password);
assertTest("Security::hashPassword generates non-empty hash", !empty($hash));
assertTest("Security::verifyPassword verifies matching password", \App\Helpers\Security::verifyPassword($password, $hash));

// ----------------------------------------------------
// 3. Test Auth & RBAC Logic
// ----------------------------------------------------
try {
    $authService = new \App\Services\AuthService();
    $user = $authService->attempt('admin@tyche.academy', 'Admin@123456', '127.0.0.1', 'PHPUnit Test');
    assertTest("AuthService authenticates Super Admin credentials", $user['email'] === 'admin@tyche.academy');
    assertTest("RbacService detects BI.ViewReports permission", \App\Services\RbacService::hasPermission('BI.ViewReports'));
    assertTest("RbacService detects SYSTEM.AdminConsole permission", \App\Services\RbacService::hasPermission('SYSTEM.AdminConsole'));
} catch (\Exception $e) {
    assertTest("Auth & RBAC Test failed: " . $e->getMessage(), false);
}

// ----------------------------------------------------
// 4. Test Phase 12 Business Intelligence Telemetry
// ----------------------------------------------------
try {
    $biService = new \App\Services\BusinessIntelligenceService();
    $metrics = $biService->getExecutiveMetrics();

    assertTest("BusinessIntelligenceService aggregates revenue, completions & health score", isset($metrics['total_revenue']) && $metrics['business_health_score'] > 90);
} catch (\Exception $e) {
    assertTest("BI Telemetry Test failed: " . $e->getMessage(), false);
}

// ----------------------------------------------------
// 5. Test Phase 13 Placement & Job Application Lifecycle
// ----------------------------------------------------
try {
    $placementService = new \App\Services\PlacementService();
    $appData = $placementService->applyForJob(1, 2, 'Applying for Technical SEO role.');

    assertTest("PlacementService records student job application", !empty($appData['status']));

} catch (\Exception $e) {
    assertTest("Placement Test failed: " . $e->getMessage(), false);
}

// ----------------------------------------------------
// 6. Test Phase 14 Coupon Engine & Discount Validation
// ----------------------------------------------------
try {
    $automationService = new \App\Services\MarketingAutomationService();
    // 15% OFF TYCHE2026 on ₹6000 course fee -> ₹900 discount -> ₹5100 final fee
    $res = $automationService->validateCoupon('TYCHE2026', 6000.00);

    assertTest("MarketingAutomationService validates 15% discount coupon (TYCHE2026)", $res['valid'] && (float)$res['discount'] === 900.00 && (float)$res['final_amount'] === 5100.00);
} catch (\Exception $e) {
    assertTest("Coupon Validation Test failed: " . $e->getMessage(), false);
}

// ----------------------------------------------------
// 7. Test Phase 14 Database Backup & System Health Diagnostic
// ----------------------------------------------------
try {
    $sysAdminService = new \App\Services\SystemAdminService();
    $backup = $sysAdminService->createBackup();
    $health = $sysAdminService->getHealthStatus();

    assertTest("SystemAdminService creates native database SQL dump file", file_exists($backup['file_path']));
    assertTest("SystemAdminService performs server health diagnostic ping", $health['status'] === 'HEALTHY');
} catch (\Exception $e) {
    assertTest("System Admin Test failed: " . $e->getMessage(), false);
}

echo "\n-----------------------------------------------------\n";
echo "TEST RESULTS: Passed: {$passed} | Failed: {$failed}\n";
echo "=====================================================\n";

if ($failed > 0) {
    exit(1);
}
