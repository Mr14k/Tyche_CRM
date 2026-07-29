<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class PasswordReset extends Model
{
    protected string $table = 'password_resets';

    public function createToken(string $email, string $tokenHash, string $expiresAt): void
    {
        Database::execute("DELETE FROM password_resets WHERE email = :email", ['email' => $email]);
        $this->create([
            'email' => $email,
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt
        ]);
    }

    public function findValidToken(string $tokenHash): ?array
    {
        $sql = "SELECT * FROM password_resets WHERE token_hash = :hash AND expires_at > NOW() LIMIT 1";
        return Database::fetchOne($sql, ['hash' => $tokenHash]);
    }

    public function deleteForEmail(string $email): void
    {
        Database::execute("DELETE FROM password_resets WHERE email = :email", ['email' => $email]);
    }
}
