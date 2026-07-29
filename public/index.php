<?php

declare(strict_types=1);

// 1. PSR-4 Autoloading Setup
$root = dirname(__DIR__);
$autoloadFile = $root . '/vendor/autoload.php';

if (file_exists($autoloadFile)) {
    require_once $autoloadFile;
} else {
    // Custom fallback autoloader if composer dump-autoload hasn't been executed
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

// 2. Instantiate and run Application
$app = new \App\Core\Application();
$app->run();
