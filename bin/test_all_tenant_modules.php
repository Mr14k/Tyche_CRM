<?php

declare(strict_types=1);

// Run via CLI: C:\xampp\php\php.exe bin/test_all_tenant_modules.php

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
echo "   Tyche Multi-Tenant Full Module Verification Suite \n";
echo "=====================================================\n\n";

$passed = 0;
$failed = 0;

function assertModule(string $moduleName, callable $fn): void
{
    global $passed, $failed;
    try {
        $fn();
        echo "[PASS] Module '{$moduleName}' executed cleanly without errors.\n";
        $passed++;
    } catch (\Throwable $e) {
        echo "[FAIL] Module '{$moduleName}' threw error: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "\n";
        $failed++;
    }
}

// Set Active Tenant to Tenant #2 (Pilot Client Academy)
\App\Core\TenantContext::setTenantId(2);

// 1. LMS Module Test
assertModule("LMS Courses & Categories", function() {
    $courseModel = new \App\Models\Course();
    $catModel = new \App\Models\CourseCategory();
    $courses = $courseModel->all();
    $categories = $catModel->all();
});

// 2. CRM Module Test
assertModule("CRM Leads Pipeline & Telemetry", function() {
    $leadModel = new \App\Models\Lead();
    $crmTelemetry = new \App\Services\CrmTelemetryService();
    $leads = $leadModel->getLeadsWithDetails();
    $metrics = $crmTelemetry->getExecutiveMetrics();
});

// 3. Finance & Invoices Module Test
assertModule("Finance Payments & GST Invoices", function() {
    $paymentModel = new \App\Models\Payment();
    $invoiceModel = new \App\Models\Invoice();
    $payments = $paymentModel->getPaymentsWithDetails();
    $invoices = $invoiceModel->getInvoicesWithDetails();
});

// 4. Executive Dashboard & BI Telemetry Test
assertModule("Executive Dashboard & BI Telemetry", function() {
    $biService = new \App\Services\BusinessIntelligenceService();
    $metrics = $biService->getExecutiveMetrics();
});

// 5. Placement & Job Board Test
assertModule("Placement Cell & Job Board", function() {
    $jobModel = new \App\Models\JobPosting();
    $appModel = new \App\Models\JobApplication();
    $jobs = $jobModel->getJobsWithEmployers();
    $apps = $appModel->getApplicationsWithDetails();
});

// 6. Marketing Automation Test
assertModule("Marketing Automation & Coupons", function() {
    $couponModel = new \App\Models\Coupon();
    $coupons = $couponModel->all();
});

// 7. System Administration Test
assertModule("System Administration & Logs", function() {
    $logModel = new \App\Models\ActivityLog();
    $logs = $logModel->all();
});

echo "\n-----------------------------------------------------\n";
echo "MODULE VERIFICATION SUMMARY: Passed: {$passed} | Failed: {$failed}\n";
echo "=====================================================\n";

if ($failed > 0) {
    exit(1);
}
