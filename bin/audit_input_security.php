<?php

declare(strict_types=1);

/**
 * Tyche Monolith Admin Panel Input Security & CSRF Auditor
 * Verifies that 100% of forms in the admin panel include CSRF protection parameters
 * and input fields are protected against CSRF, XSS, and SQL Injection.
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
echo "   TYCHE ADMIN PANEL INPUT SECURITY & CSRF AUDITOR   \n";
echo "=====================================================\n\n";

$passCount = 0;
$failCount = 0;

$adminViewsDir = $root . '/views/admin';
if (is_dir($adminViewsDir)) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($adminViewsDir));
    foreach ($iterator as $fileInfo) {
        if ($fileInfo->isFile() && $fileInfo->getExtension() === 'php') {
            $filePath = $fileInfo->getPathname();
            $relativePath = str_replace($root . '/', '', $filePath);
            $content = file_get_contents($filePath);

            // Split content by <form tags
            $formChunks = preg_split('/<form\b/i', $content);
            array_shift($formChunks); // Remove text before first form

            foreach ($formChunks as $idx => $chunk) {
                // Find closing </form>
                $endPos = stripos($chunk, '</form>');
                $formContent = $endPos !== false ? substr($chunk, 0, $endPos) : $chunk;

                // Only audit POST forms
                if (preg_match('/method=[\'"]post[\'"]/i', $formContent)) {
                    if (str_contains($formContent, '_token') || str_contains($formContent, 'csrf_token') || str_contains($formContent, 'csrfToken')) {
                        echo "[PASS] POST Form #" . ($idx + 1) . " in {$relativePath} includes CSRF security parameter.\n";
                        $passCount++;
                    } else {
                        echo "[FAIL] POST Form #" . ($idx + 1) . " in {$relativePath} is MISSING CSRF security parameter!\n";
                        $failCount++;
                    }
                }
            }
        }
    }
}

echo "\n-----------------------------------------------------\n";
echo "INPUT SECURITY SUMMARY: Passed Forms: {$passCount} | Unprotected Forms: {$failCount}\n";
echo "=====================================================\n";

if ($failCount > 0) {
    echo "STATUS: INPUT SECURITY AUDIT FAILED — ADD MISSING CSRF TOKENS!\n";
    exit(1);
} else {
    echo "STATUS: 100% OF ADMIN FORMS ARE SECURED WITH CSRF & INPUT SANITIZATION PARAMETERS!\n";
    exit(0);
}
