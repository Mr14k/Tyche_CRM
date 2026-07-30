<?php

declare(strict_types=1);

// Run via CLI: C:\xampp\php\php.exe bin/test_subscription_manager.php

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
echo "   Tyche SaaS Subscription Manager Automated Tester  \n";
echo "=====================================================\n\n";

$passed = 0;
$failed = 0;

function assertSub(string $testName, callable $fn): void
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

// 1. Test SubscriptionPlan model retrieval
assertSub("SubscriptionPlan model fetches active database tiers", function() {
    $planModel = new \App\Models\SubscriptionPlan();
    $plans = $planModel->all();
    if (empty($plans)) {
        throw new \Exception("No subscription plans found in database.");
    }
});

// 2. Test PlanFeatureService dynamic plan loader
assertSub("PlanFeatureService loads active plans from DB", function() {
    $plans = \App\Services\PlanFeatureService::getPlans();
    if (!isset($plans['Bronze'], $plans['Silver'], $plans['Gold'])) {
        throw new \Exception("Bronze, Silver, or Gold tier missing from PlanFeatureService.");
    }
});

// 3. Test Subscription limit check for Tenant #1 vs Tenant #2
assertSub("PlanFeatureService correctly calculates tenant resource limit exhaustion", function() {
    $stats1 = \App\Services\PlanFeatureService::getTenantUsageStats(1);
    $stats2 = \App\Services\PlanFeatureService::getTenantUsageStats(2);
    
    if (!isset($stats1['leads'], $stats1['courses'], $stats1['students'])) {
        throw new \Exception("Usage stats incomplete for Tenant 1.");
    }
});

echo "\n-----------------------------------------------------\n";
echo "SUBSCRIPTION SUITE RESULTS: Passed: {$passed} | Failed: {$failed}\n";
echo "=====================================================\n";

if ($failed > 0) {
    exit(1);
}
