<?php

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

use App\Core\TenantContext;
use App\Models\CourseCategory;

echo "Testing Multi-Tenant Course Category Auto-Seeding across Tenants 2, 3, 4...\n";

foreach ([2, 3, 4] as $tid) {
    TenantContext::setTenantId($tid);
    $categoryModel = new CourseCategory();
    $categories = $categoryModel->getCategoriesForActiveTenant();
    echo "Tenant {$tid} Category Count: " . count($categories) . "\n";
    if (empty($categories)) {
        echo "[FAIL] Tenant {$tid} failed to seed categories!\n";
        exit(1);
    }
}

echo "[PASS] Multi-tenant course category auto-seeding verified clean across all tenants!\n";
exit(0);
