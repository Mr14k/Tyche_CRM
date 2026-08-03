<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use App\Core\TenantContext;

class SiteSetting extends Model
{
    protected string $table = 'site_settings';

    public static function get(string $key, ?string $default = null): ?string
    {
        $tid = TenantContext::getTenantId();
        $res = Database::fetchOne("SELECT setting_value FROM site_settings WHERE setting_key = :k AND tenant_id = :tid LIMIT 1", [
            'k' => $key,
            'tid' => $tid
        ]);
        return $res ? $res['setting_value'] : $default;
    }

    public static function set(string $key, ?string $value): void
    {
        $tid = TenantContext::getTenantId();
        $sql = "INSERT INTO site_settings (tenant_id, setting_key, setting_value) VALUES (:tid, :k, :v)
                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)";
        Database::execute($sql, ['tid' => $tid, 'k' => $key, 'v' => $value]);
    }

    public static function getAllAsMap(): array
    {
        $tid = TenantContext::getTenantId();
        $rows = Database::fetchAll("SELECT * FROM site_settings WHERE tenant_id = :tid", ['tid' => $tid]);
        $map = [];
        foreach ($rows as $r) {
            $map[$r['setting_key']] = $r['setting_value'];
        }
        return $map;
    }
}
