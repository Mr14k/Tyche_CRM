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

echo "Testing Multi-Tenant Course Category Auto-Seeding...\n";

// Test for Tenant 2 (Simulating a new tenant with no initial categories)
TenantContext::setTenantId(2);

$categoryModel = new CourseCategory();
$categories = $categoryModel->getCategoriesForActiveTenant();

echo "Tenant 2 Category Count: " . count($categories) . "\n";
print_r(array_column($categories, 'name'));

if (!empty($categories) && count($categories) >= 5) {
    echo "[PASS] Multi-tenant course category auto-seeding verified!\n";
    exit(0);
} else {
    echo "[FAIL] Failed to auto-seed categories for tenant!\n";
    exit(1);
}
