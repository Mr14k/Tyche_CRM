<?php

declare(strict_types=1);

// CLI Script: Create or Reset Super Admin User Credentials
// Run: C:\xampp\php\php.exe bin/create_admin.php

$root = dirname(__DIR__);
require_once $root . '/app/Core/EnvLoader.php';
\App\Core\EnvLoader::load($root . '/.env');

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = (int)($_ENV['DB_PORT'] ?? 3306);
$dbName = $_ENV['DB_NAME'] ?? 'tyche_db';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

echo "=====================================================\n";
echo "   Tyche CRM/Academy - Super Admin Account Setup     \n";
echo "=====================================================\n\n";

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $adminEmail = 'admin@tyche.academy';
    $adminPass = 'Admin@123';
    $hash = password_hash($adminPass, PASSWORD_BCRYPT, ['cost' => 12]);

    // Check if admin user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $adminEmail]);
    $user = $stmt->fetch();

    if ($user) {
        $userId = (int)$user['id'];
        $update = $pdo->prepare("UPDATE users SET password_hash = :hash, status = 'active', failed_login_attempts = 0, locked_until = NULL WHERE id = :id");
        $update->execute(['hash' => $hash, 'id' => $userId]);
        echo "[✓] Password updated for existing Super Admin ({$adminEmail}).\n";
    } else {
        $insert = $pdo->prepare("INSERT INTO users (first_name, last_name, email, phone, password_hash, status, created_at) VALUES ('Super', 'Admin', :email, '+91 9876543210', :hash, 'active', NOW())");
        $insert->execute(['email' => $adminEmail, 'hash' => $hash]);
        $userId = (int)$pdo->lastInsertId();
        echo "[✓] New Super Admin user created ({$adminEmail}).\n";
    }

    // Ensure Admin & Super Admin roles (Role ID 1 & 2) are attached
    foreach ([1, 2] as $roleId) {
        $checkRole = $pdo->prepare("SELECT COUNT(*) FROM user_roles WHERE user_id = :uid AND role_id = :rid");
        $checkRole->execute(['uid' => $userId, 'rid' => $roleId]);
        if ((int)$checkRole->fetchColumn() === 0) {
            $addRole = $pdo->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:uid, :rid)");
            $addRole->execute(['uid' => $userId, 'rid' => $roleId]);
        }
    }

    echo "[✓] Role permissions assigned successfully.\n\n";
    echo "-----------------------------------------------------\n";
    echo " SUPER ADMIN CREDENTIALS:\n";
    echo " Email:    {$adminEmail}\n";
    echo " Password: {$adminPass}\n";
    echo " Login URL: http://localhost/tyche/public/login\n";
    echo "-----------------------------------------------------\n\n";

} catch (Exception $e) {
    echo "[X] Error: " . $e->getMessage() . "\n";
    exit(1);
}
