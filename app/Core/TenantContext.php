<?php

declare(strict_types=1);

namespace App\Core;

class TenantContext
{
    private static int $tenantId = 1; // Default to Primary Tenant (ID 1)
    private static ?array $tenantData = null;

    public static function setTenantId(int $id, ?array $data = null): void
    {
        self::$tenantId = $id;
        if ($data !== null) {
            self::$tenantData = $data;
        }
    }

    public static function getTenantId(): int
    {
        return self::$tenantId;
    }

    public static function getTenantData(): ?array
    {
        return self::$tenantData;
    }

    public static function reset(): void
    {
        self::$tenantId = 1;
        self::$tenantData = null;
    }
}
