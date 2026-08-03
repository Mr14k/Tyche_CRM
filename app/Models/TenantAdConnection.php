<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use App\Helpers\Security;

class TenantAdConnection extends Model
{
    protected string $table = 'tenant_ad_connections';
    protected bool $tenantScoped = true;

    public function findByPageOrAccount(string $platform, string $pageOrAccountId): ?array
    {
        // Unscoped query for incoming webhook lookup by page_id / account_id
        $sql = "SELECT * FROM tenant_ad_connections WHERE platform = :platform AND page_or_account_id = :id LIMIT 1";
        return Database::fetchOne($sql, ['platform' => $platform, 'id' => $pageOrAccountId]);
    }

    public function saveConnection(int $tenantId, string $platform, string $pageOrAccountId, string $accessToken, ?string $refreshToken = null, ?string $webhookSecret = null, ?string $expiresAt = null): int
    {
        $encryptedAccess = Security::encryptSecret($accessToken);
        $encryptedRefresh = $refreshToken ? Security::encryptSecret($refreshToken) : null;
        $encryptedSecret = $webhookSecret ? Security::encryptSecret($webhookSecret) : null;

        $existing = Database::fetchOne("SELECT id FROM tenant_ad_connections WHERE tenant_id = :tid AND platform = :p AND page_or_account_id = :aid", [
            'tid' => $tenantId,
            'p' => $platform,
            'aid' => $pageOrAccountId
        ]);

        if ($existing) {
            Database::execute("UPDATE tenant_ad_connections SET 
                access_token_encrypted = :access,
                refresh_token_encrypted = :refresh,
                webhook_secret_encrypted = :secret,
                token_expires_at = :expires,
                status = 'active',
                updated_at = NOW()
                WHERE id = :id AND tenant_id = :tid", [
                    'access' => $encryptedAccess,
                    'refresh' => $encryptedRefresh,
                    'secret' => $encryptedSecret,
                    'expires' => $expiresAt,
                    'id' => $existing['id'],
                    'tid' => $tenantId
                ]);
            return (int)$existing['id'];
        }

        return (int)Database::insert("INSERT INTO tenant_ad_connections 
            (tenant_id, platform, page_or_account_id, access_token_encrypted, refresh_token_encrypted, webhook_secret_encrypted, token_expires_at, status) 
            VALUES (:tid, :p, :aid, :access, :refresh, :secret, :expires, 'active')", [
                'tid' => $tenantId,
                'p' => $platform,
                'aid' => $pageOrAccountId,
                'access' => $encryptedAccess,
                'refresh' => $encryptedRefresh,
                'secret' => $encryptedSecret,
                'expires' => $expiresAt
            ]);
    }
}
