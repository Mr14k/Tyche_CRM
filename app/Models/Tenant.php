<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Tenant extends Model
{
    protected string $table = 'tenants';
    protected bool $tenantScoped = false; // Master tenants table is global

    public function findBySubdomain(string $subdomain): ?array
    {
        return $this->findOneWhere('subdomain', strtolower(trim($subdomain)));
    }
}
