<?php

declare(strict_types=1);

// Run via CLI: C:\xampp\php\php.exe bin/test_spa_engine.php

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
echo "   Tyche Monolith SPA Engine Verification Tester     \n";
echo "=====================================================\n\n";

$passed = 0;
$failed = 0;

function assertSpa(string $testName, callable $fn): void
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

// 1. Verify spa-engine.js exists in public/assets/js
assertSpa("spa-engine.js asset file exists and is non-empty", function() use ($root) {
    $spaFile = $root . '/public/assets/js/spa-engine.js';
    if (!file_exists($spaFile) || filesize($spaFile) < 100) {
        throw new \Exception("spa-engine.js missing or empty.");
    }
});

// 2. Verify views/layouts/admin.php contains app-content container and spa-loader-bar
assertSpa("admin.php layout contains #app-content and #spa-loader-bar", function() use ($root) {
    $layoutFile = $root . '/views/layouts/admin.php';
    $content = file_get_contents($layoutFile);
    if (!str_contains($content, 'id="app-content"') || !str_contains($content, 'id="spa-loader-bar"')) {
        throw new \Exception("Layout missing #app-content or #spa-loader-bar.");
    }
});

echo "\n-----------------------------------------------------\n";
echo "SPA ENGINE RESULTS: Passed: {$passed} | Failed: {$failed}\n";
echo "=====================================================\n";

if ($failed > 0) {
    exit(1);
}
