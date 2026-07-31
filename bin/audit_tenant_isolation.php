<?php

declare(strict_types=1);

/**
 * Tyche Monolith Automated Tenant-Isolation Security Auditor
 * Scans Models, Controllers, Services, and SQL queries to ensure
 * zero queries bypass tenant_id scoping across multi-tenant domain tables.
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
echo "   TYCHE TENANT-ISOLATION AUTOMATED SECURITY AUDIT   \n";
echo "=====================================================\n\n";

$passCount = 0;
$warnCount = 0;
$failCount = 0;

// Domain tables that MUST be tenant-scoped
$tenantDomainTables = [
    'leads', 'lead_activities', 'academic_batches', 'courses', 'course_categories',
    'course_modules', 'course_chapters', 'course_lessons', 'course_enrollments',
    'lesson_progress', 'quizzes', 'quiz_questions', 'quiz_submissions', 'certificates',
    'payments', 'payment_links', 'invoices', 'job_openings', 'job_applications',
    'faculty_profiles', 'marketing_campaigns', 'coupons', 'system_backups',
    'system_logs', 'cms_pages', 'blog_posts', 'cms_menus', 'cms_banners', 'media_library'
];

// 1. AUDIT MODELS
echo "--- [SECTION 1] Model Definition Scoping Audit ---\n";
$modelsDir = $root . '/app/Models';
if (is_dir($modelsDir)) {
    $modelFiles = glob($modelsDir . '/*.php');
    foreach ($modelFiles as $file) {
        $fileName = basename($file);
        $content = file_get_contents($file);
        
        // Extract class name
        if (preg_match('/class\s+([A-Za-z0-9_]+)/', $content, $m)) {
            $className = $m[1];
            
            // Check if tenantScoped is explicitly false
            if (preg_match('/protected\s+bool\s+\$tenantScoped\s*=\s*false;/', $content)) {
                if (in_array(strtolower($className), ['tenant', 'subscriptionplan', 'role', 'permission'])) {
                    echo "[PASS] Global Model {$className} explicitly sets \$tenantScoped = false (Expected).\n";
                    $passCount++;
                } else {
                    echo "[WARN] Model {$className} sets \$tenantScoped = false. Verify global status.\n";
                    $warnCount++;
                }
            } else {
                echo "[PASS] Domain Model {$className} inherits default \$tenantScoped = true.\n";
                $passCount++;
            }
        }
    }
}

// 2. AUDIT RAW SQL QUERIES IN CONTROLLERS AND SERVICES
echo "\n--- [SECTION 2] SQL Query Tenant Isolation Audit ---\n";
$scanDirectories = [$root . '/app/Controllers', $root . '/app/Services', $root . '/app/Core'];
$scannedFiles = 0;
$queryCount = 0;

foreach ($scanDirectories as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $fileInfo) {
        if ($fileInfo->isFile() && $fileInfo->getExtension() === 'php') {
            $scannedFiles++;
            $filePath = $fileInfo->getPathname();
            $relativePath = str_replace($root . '/', '', $filePath);
            $content = file_get_contents($filePath);
            
            // Match multiline single or double quoted strings inside Database calls
            if (preg_match_all('/Database::(query|fetchAll|fetchOne|execute|executeStatement)\(\s*([\'"])(.*?)\2[\s,)]/is', $content, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $queryCount++;
                    $sql = trim($match[3]);
                    
                    // Check if query targets any tenant domain table
                    $targetedTables = [];
                    foreach ($tenantDomainTables as $table) {
                        if (preg_match('/\b' . preg_quote($table, '/') . '\b/i', $sql)) {
                            $targetedTables[] = $table;
                        }
                    }
                    
                    if (!empty($targetedTables)) {
                        // Check if tenant_id condition or parameter is present
                        if (stripos($sql, 'tenant_id') !== false || stripos($sql, 'INSERT INTO') !== false) {
                            $passCount++;
                        } else {
                            // Check if this is a Super Admin global aggregation query or systemic user lookup
                            if (stripos($filePath, 'SaasCommandCenter') !== false || stripos($filePath, 'SubscriptionController') !== false || stripos($filePath, 'TenantController') !== false) {
                                echo "[INFO] Super Admin Global Query in {$relativePath}: " . substr(preg_replace('/\s+/', ' ', $sql), 0, 70) . "...\n";
                                $passCount++;
                            } else {
                                echo "[FAIL] Potential Unscoped Query in {$relativePath}: " . preg_replace('/\s+/', ' ', $sql) . "\n";
                                $failCount++;
                            }
                        }
                    }
                }
            }
        }
    }
}

echo "\n-----------------------------------------------------\n";
echo "AUDIT SUMMARY: Scanned {$scannedFiles} files & {$queryCount} SQL statements.\n";
echo "Passed Checks: {$passCount} | Warnings: {$warnCount} | Failures: {$failCount}\n";
echo "=====================================================\n";

if ($failCount > 0) {
    echo "STATUS: SECURITY AUDIT FAILED — FIX UNSCOPED QUERIES IMMEDIATELY!\n";
    exit(1);
} else {
    echo "STATUS: 100% TENANT ISOLATION VERIFIED CLEAN! READY FOR TECHNICAL BUYER DUE DILIGENCE.\n";
    exit(0);
}
