<?php

declare(strict_types=1);

/**
 * Tyche Monolith Cloud Storage Service Verification Test
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
echo "   TYCHE CLOUD STORAGE SERVICE VERIFICATION TEST     \n";
echo "=====================================================\n\n";

$passed = 0;
$failed = 0;

function assertStorage(string $testName, callable $fn): void
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

// 1. Instantiation
assertStorage("StorageService instantiates cleanly", function() {
    $storage = new \App\Services\StorageService();
    if (!$storage) throw new \Exception("Failed to instantiate StorageService.");
});

// 2. Local File Upload & Storage URL Generation
assertStorage("StorageService stores file locally and generates valid asset URL", function() use ($root) {
    $storage = new \App\Services\StorageService();
    
    // Create temporary dummy media file
    $tmpFile = sys_get_temp_dir() . '/test_video_' . time() . '.txt';
    file_put_contents($tmpFile, 'Tyche Cloud Video Payload Sample Data');

    $relativePath = 'courses/videos/sample_lesson_' . time() . '.txt';
    $url = $storage->putFile($relativePath, $tmpFile, 'text/plain');

    if (empty($url) || !str_contains($url, 'uploads/courses/videos/sample_lesson_')) {
        throw new \Exception("Invalid URL returned by StorageService: {$url}");
    }

    // Verify file actually stored on disk
    $storedDiskPath = $root . '/public/uploads/' . $relativePath;
    if (!file_exists($storedDiskPath)) {
        throw new \Exception("File was not written to disk at {$storedDiskPath}");
    }

    // Cleanup
    unlink($tmpFile);
    $storage->deleteFile($relativePath);
});

echo "\n-----------------------------------------------------\n";
echo "STORAGE TEST SUMMARY: Passed: {$passed} | Failed: {$failed}\n";
echo "=====================================================\n";

if ($failed > 0) {
    exit(1);
}
