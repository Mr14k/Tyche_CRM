<?php

declare(strict_types=1);

/**
 * Tyche Monolith Meta Ads & Google Ads Direct Lead Ingestion Test Suite
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

echo "=====================================================================\n";
echo "   META ADS & GOOGLE ADS DIRECT LEAD INGESTION TEST SUITE            \n";
echo "=====================================================================\n\n";

$passed = 0;
$failed = 0;

function assertAdTest(string $testName, callable $fn): void
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

// 1. Encryption Helper Verification
assertAdTest("Security::encryptSecret and decryptSecret securely encrypt access tokens at rest", function() {
    $plainToken = "EAAXXXXXXX_META_TEST_TOKEN_SECRET_12345";
    $encrypted = \App\Helpers\Security::encryptSecret($plainToken);
    
    if (empty($encrypted) || $encrypted === $plainToken) {
        throw new \Exception("Encryption failed or returned plaintext string.");
    }

    $decrypted = \App\Helpers\Security::decryptSecret($encrypted);
    if ($decrypted !== $plainToken) {
        throw new \Exception("Decryption mismatch: expected '{$plainToken}', got '{$decrypted}'");
    }
});

// 2. Tenant Ad Connection Model & Encryption
assertAdTest("TenantAdConnection model saves & retrieves encrypted Page Connection", function() {
    \App\Core\TenantContext::setTenantId(1);
    $connModel = new \App\Models\TenantAdConnection();
    
    $pageId = "page_meta_1001_" . time();
    $id = $connModel->saveConnection(1, 'meta', $pageId, 'access_token_tenant1');

    if ($id <= 0) {
        throw new \Exception("Failed to save TenantAdConnection record.");
    }

    $fetched = $connModel->findByPageOrAccount('meta', $pageId);
    if (!$fetched || (int)$fetched['tenant_id'] !== 1) {
        throw new \Exception("Failed to lookup ad connection by page ID.");
    }
});

// 3. Meta Signature Verification
assertAdTest("AdLeadIngestionService verifies Meta HMAC-SHA256 X-Hub-Signature-256 header", function() {
    $service = new \App\Services\AdLeadIngestionService();
    $body = '{"entry":[{"id":"1001","changes":[{"value":{"leadgen_id":"123","page_id":"456"}}]}]}';
    $secret = 'MySecretAppKey123';
    
    $calcSig = 'sha256=' . hash_hmac('sha256', $body, $secret);

    if (!$service->verifyMetaSignature($body, $calcSig, $secret)) {
        throw new \Exception("Valid signature check failed.");
    }

    if ($service->verifyMetaSignature($body, 'sha256=invalid_hash', $secret)) {
        throw new \Exception("SECURITY FAILURE: Invalid signature passed verification!");
    }
});

// 4. Meta Webhook Lead Ingestion & Scoping
assertAdTest("Meta Webhook processes payload & injects lead into Tenant 1 CRM", function() {
    \App\Core\TenantContext::setTenantId(1);
    $connModel = new \App\Models\TenantAdConnection();
    $pageId = "meta_page_active_" . rand(1000, 9999);
    $connModel->saveConnection(1, 'meta', $pageId, 'valid_page_token_123');

    $service = new \App\Services\AdLeadIngestionService();
    $leadgenId = "leadgen_" . time() . "_" . rand(100, 999);
    
    $payload = [
        'entry' => [
            [
                'id' => '1001',
                'changes' => [
                    [
                        'field' => 'leadgen',
                        'value' => [
                            'page_id' => $pageId,
                            'leadgen_id' => $leadgenId,
                            'form_id' => 'form_999'
                        ]
                    ]
                ]
            ]
        ]
    ];

    $res = $service->processMetaLeadgenPayload($payload);
    if ($res['status'] !== 'success' || empty($res['lead_id'])) {
        throw new \Exception("Meta leadgen payload processing failed: " . json_encode($res));
    }

    // Verify Lead in Database
    $lead = (new \App\Models\Lead())->find((int)$res['lead_id']);
    if (!$lead || $lead['source'] !== 'meta_ads' || (int)$lead['tenant_id'] !== 1) {
        throw new \Exception("Ingested lead record invalid or missing expected source/tenant.");
    }
});

// 5. Google Ads Webhook Ingestion & Deduplication
assertAdTest("Google Ads Webhook processes payload & handles duplicate submissions", function() {
    \App\Core\TenantContext::setTenantId(1);
    $connModel = new \App\Models\TenantAdConnection();
    $googleKey = "g_key_" . time();
    $connModel->saveConnection(1, 'google', $googleKey, $googleKey, null, $googleKey);

    $service = new \App\Services\AdLeadIngestionService();
    $uniquePhone = "+9199" . rand(10000000, 99999999);
    $uniqueEmail = "googlead_" . time() . "_" . rand(100, 999) . "@example.com";

    $googlePayload = [
        'google_key' => $googleKey,
        'lead_id' => 'g_lead_' . time(),
        'user_column_data' => [
            ['column_id' => 'FULL_NAME', 'string_value' => 'Google Ads Prospect'],
            ['column_id' => 'EMAIL', 'string_value' => $uniqueEmail],
            ['column_id' => 'PHONE_NUMBER', 'string_value' => $uniquePhone]
        ]
    ];

    $res1 = $service->processGoogleAdsPayload($googlePayload);
    if ($res1['status'] !== 'success') {
        throw new \Exception("Google Ads lead ingestion failed: " . json_encode($res1));
    }

    // Repeat Submission Deduplication Test
    $res2 = $service->processGoogleAdsPayload($googlePayload);
    if ($res2['status'] !== 'duplicate') {
        throw new \Exception("Deduplication check failed: Expected 'duplicate', got '{$res2['status']}'");
    }
});

echo "\n-----------------------------------------------------\n";
echo "AD INTEGRATION TEST SUMMARY: Passed: {$passed} | Failed: {$failed}\n";
echo "=====================================================\n";

if ($failed > 0) {
    exit(1);
}
