<?php

declare(strict_types=1);

/**
 * Tyche Multi-Tenant Payment Gateway Isolation Verification Test
 */

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
echo "   MULTI-TENANT PAYMENT GATEWAY ISOLATION TEST       \n";
echo "=====================================================\n\n";

$passed = 0;
$failed = 0;

function assertGateway(string $testName, callable $fn): void
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

// 1. Save and Verify Tenant 1 Gateway Credentials
assertGateway("Tenant 1 (Academy A) saves individual Razorpay credentials", function() {
    \App\Core\TenantContext::setTenantId(1);
    $service = new \App\Services\PaymentGatewayService();
    
    $service->saveTenantGatewaySettings([
        'payment_active_gateway' => 'razorpay',
        'razorpay_key_id' => 'rzp_live_TENANT1_KEY_123',
        'razorpay_key_secret' => 'TENANT1_SECRET_ABC'
    ]);

    $config = $service->getActiveGatewayConfig(1);
    if ($config['active_gateway'] !== 'razorpay' || $config['razorpay']['key_id'] !== 'rzp_live_TENANT1_KEY_123') {
        throw new \Exception("Tenant 1 credentials failed to save or match.");
    }
});

// 2. Verify Tenant Isolation - Tenant 2 (Academy B) cannot see Tenant 1 Credentials
assertGateway("Tenant 2 (Academy B) receives isolated empty/separate credentials", function() {
    \App\Core\TenantContext::setTenantId(2);
    $service = new \App\Services\PaymentGatewayService();

    // Check Tenant 2 config
    $config2 = $service->getActiveGatewayConfig(2);
    if ($config2['razorpay']['key_id'] === 'rzp_live_TENANT1_KEY_123') {
        throw new \Exception("SECURITY FAILURE: Tenant 2 accessed Tenant 1's Razorpay Key ID!");
    }

    // Save Tenant 2 distinct credentials
    $service->saveTenantGatewaySettings([
        'payment_active_gateway' => 'stripe',
        'stripe_publishable_key' => 'pk_live_TENANT2_STRIPE_XYZ',
        'stripe_secret_key' => 'sk_live_TENANT2_SECRET_789'
    ]);

    $config2Updated = $service->getActiveGatewayConfig(2);
    if ($config2Updated['active_gateway'] !== 'stripe' || $config2Updated['stripe']['publishable_key'] !== 'pk_live_TENANT2_STRIPE_XYZ') {
        throw new \Exception("Tenant 2 custom Stripe credentials failed to save.");
    }
});

// 3. Verify Cross-Tenant Isolation Guarantee
assertGateway("Cross-tenant isolation holds after switching back to Tenant 1 Context", function() {
    \App\Core\TenantContext::setTenantId(1);
    $service = new \App\Services\PaymentGatewayService();
    $config1 = $service->getActiveGatewayConfig(1);

    if ($config1['razorpay']['key_id'] !== 'rzp_live_TENANT1_KEY_123') {
        throw new \Exception("Tenant 1 credentials corrupted after Tenant 2 updates.");
    }
    if (!empty($config1['stripe']['publishable_key'])) {
        throw new \Exception("SECURITY FAILURE: Tenant 1 accessed Tenant 2's Stripe Key!");
    }
});

echo "\n-----------------------------------------------------\n";
echo "PAYMENT GATEWAY TEST SUMMARY: Passed: {$passed} | Failed: {$failed}\n";
echo "=====================================================\n";

if ($failed > 0) {
    exit(1);
}
