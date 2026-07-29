<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class SiteSetting extends Model
{
    protected string $table = 'site_settings';
    protected string $primaryKey = 'setting_key';

    public static function get(string $key, ?string $default = null): ?string
    {
        $res = Database::fetchOne("SELECT setting_value FROM site_settings WHERE setting_key = :k LIMIT 1", ['k' => $key]);
        return $res ? $res['setting_value'] : $default;
    }

    public static function set(string $key, ?string $value): void
    {
        $sql = "INSERT INTO site_settings (setting_key, setting_value) VALUES (:k, :v)
                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)";
        Database::execute($sql, ['k' => $key, 'v' => $value]);
    }

    public static function getAllAsMap(): array
    {
        $rows = Database::fetchAll("SELECT * FROM site_settings");
        $map = [];
        foreach ($rows as $r) {
            $map[$r['setting_key']] = $r['setting_value'];
        }
        return $map;
    }
}
