<?php
$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SCRIPT_NAME'] = '/tyche/index.php';

$url1 = \App\Helpers\Url::to('/tyche/admin/crm/leads');
$url2 = \App\Helpers\Url::to('/admin/crm/leads');

echo "Test 1 (with /tyche/): " . $url1 . "\n";
echo "Test 2 (normal): " . $url2 . "\n";

if ($url1 === 'http://localhost/tyche/admin/crm/leads' && $url2 === 'http://localhost/tyche/admin/crm/leads') {
    echo "[PASS] Url::to successfully strips duplicate subfolder!\n";
} else {
    echo "[FAIL] Url::to failed!\n";
}
