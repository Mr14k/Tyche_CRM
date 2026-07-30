<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use App\Core\TenantContext;

class Lead extends Model
{
    protected string $table = 'leads';

    public function getLeadsWithDetails(?array $filters = []): array
    {
        $tid = TenantContext::getTenantId();
        $sql = "SELECT l.*, c.title as course_title, c.price, c.discount_price, c.live_cohort_price,
                       b.batch_name, u.first_name as counselor_first, u.last_name as counselor_last 
                FROM leads l
                LEFT JOIN courses c ON l.course_id = c.id
                LEFT JOIN batches b ON l.batch_id = b.id
                LEFT JOIN users u ON l.counselor_id = u.id
                WHERE l.tenant_id = :tid";
        
        $params = ['tid' => $tid];

        if (!empty($filters['status'])) {
            $sql .= " AND l.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['source'])) {
            $sql .= " AND l.source = :source";
            $params['source'] = $filters['source'];
        }

        if (!empty($filters['counselor_id'])) {
            $sql .= " AND l.counselor_id = :counselor_id";
            $params['counselor_id'] = (int)$filters['counselor_id'];
        }

        if (!empty($filters['course_id'])) {
            $sql .= " AND l.course_id = :course_id";
            $params['course_id'] = (int)$filters['course_id'];
        }

        if (!empty($filters['is_sla_breached'])) {
            $sql .= " AND l.is_sla_breached = 1";
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (l.first_name LIKE :s OR l.last_name LIKE :s OR l.email LIKE :s OR l.phone LIKE :s OR l.lead_code LIKE :s)";
            $params['s'] = '%' . $filters['search'] . '%';
        }

        $sql .= " ORDER BY l.created_at DESC";

        return Database::fetchAll($sql, $params);
    }

    public function findLead360(int $id): ?array
    {
        $tid = TenantContext::getTenantId();
        $sql = "SELECT l.*, c.title as course_title, c.slug as course_slug, c.price, c.discount_price, c.live_cohort_price,
                       b.batch_name, b.start_date as batch_start_date, b.schedule_type,
                       u.first_name as counselor_first, u.last_name as counselor_last, u.email as counselor_email
                FROM leads l
                LEFT JOIN courses c ON l.course_id = c.id
                LEFT JOIN batches b ON l.batch_id = b.id
                LEFT JOIN users u ON l.counselor_id = u.id
                WHERE l.id = :id AND l.tenant_id = :tid LIMIT 1";
        return Database::fetchOne($sql, ['id' => $id, 'tid' => $tid]);
    }
}
