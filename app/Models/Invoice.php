<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use App\Core\TenantContext;

class Invoice extends Model
{
    protected string $table = 'invoices';
    protected bool $timestamps = false;

    public function getInvoicesWithDetails(): array
    {
        $tid = TenantContext::getTenantId();
        $sql = "SELECT inv.*, u.first_name, u.last_name, u.email, p.payment_reference, p.gateway
                FROM invoices inv
                JOIN users u ON inv.user_id = u.id
                JOIN payments p ON inv.payment_id = p.id
                WHERE inv.tenant_id = :tid
                ORDER BY inv.issued_at DESC";
        return Database::fetchAll($sql, ['tid' => $tid]);
    }
}
