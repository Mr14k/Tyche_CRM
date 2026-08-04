<?php

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

use App\Core\Database;
use App\Core\TenantContext;
use App\Services\CrmPaymentLinkService;

echo "Testing Offline Cash Payment & Instant Student Enrollment Engine...\n";

TenantContext::setTenantId(1);
$linkService = new CrmPaymentLinkService();

// Find an existing un-enrolled lead or create test lead
$lead = Database::fetchOne("SELECT * FROM leads WHERE tenant_id = 1 AND status != 'enrolled' LIMIT 1");
if (!$lead) {
    echo "[FAIL] No eligible lead found for testing.\n";
    exit(1);
}

$leadId = (int)$lead['id'];
$courseId = (int)$lead['course_id'];
$amount = 25000.00;

$res = $linkService->recordOfflinePaymentAndEnroll(
    $leadId,
    $courseId,
    null,
    $amount,
    'cash',
    'CASH-TEST-8829',
    'Collected Rs 25,000 cash at front desk',
    1
);

// Verify lead status in database
$updatedLead = Database::fetchOne("SELECT status, lead_score FROM leads WHERE id = :id", ['id' => $leadId]);

echo "Result User ID: {$res['user_id']} | Invoice: {$res['invoice_number']} | Reference: {$res['reference']}\n";
echo "Updated Lead Status: {$updatedLead['status']} | Lead Score: {$updatedLead['lead_score']}\n";

if ($updatedLead['status'] === 'enrolled' && (int)$updatedLead['lead_score'] === 100 && !empty($res['invoice_number'])) {
    echo "[PASS] Offline Cash Payment & Instant Enrollment verified clean!\n";
    exit(0);
} else {
    echo "[FAIL] Offline cash payment conversion failed!\n";
    exit(1);
}
