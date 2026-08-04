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
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Services\LeadCrmService;

echo "Testing Lead 360° Activity Logger...\n";

TenantContext::setTenantId(1);
$crmService = new LeadCrmService();

// Find an existing lead or create test lead
$lead = Database::fetchOne("SELECT id FROM leads WHERE tenant_id = 1 LIMIT 1");
if (!$lead) {
    echo "[FAIL] No lead found for testing.\n";
    exit(1);
}

$leadId = (int)$lead['id'];
$testNotes = "Spoke with student regarding Digital Marketing batch syllabus. Student confirmed attendance for Saturday demo.";

$crmService->logActivity($leadId, 'call', 'connected', $testNotes, 180, 1);

// Verify activity entry in lead_activities
$latestAct = Database::fetchOne("SELECT * FROM lead_activities WHERE lead_id = :lid ORDER BY id DESC LIMIT 1", ['lid' => $leadId]);

if ($latestAct && $latestAct['notes'] === $testNotes && (int)$latestAct['duration_seconds'] === 180) {
    echo "[PASS] Successfully logged call activity to 360° timeline!\n";
    echo "Logged ID: {$latestAct['id']} | Type: {$latestAct['type']} | Outcome: {$latestAct['outcome']} | Duration: {$latestAct['duration_seconds']}s\n";
    exit(0);
} else {
    echo "[FAIL] Failed to log activity to timeline!\n";
    exit(1);
}
