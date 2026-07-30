<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Database;
use App\Core\TenantContext;

class CrmTelemetryService extends Service
{
    public function getExecutiveMetrics(?int $tenantId = null): array
    {
        $tid = $tenantId ?? TenantContext::getTenantId();

        $totalLeads = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE tenant_id = :tid", ['tid' => $tid])['c'] ?? 0);
        $newLeads = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'new' AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0);
        $contactedLeads = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status NOT IN ('new') AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0);
        $enrolledLeads = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'enrolled' AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0);
        $lostLeads = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'lost' AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0);
        $slaBreaches = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE is_sla_breached = 1 AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0);

        $contactedPct = $totalLeads > 0 ? round(($contactedLeads / $totalLeads) * 100, 1) : 0;
        $conversionPct = $totalLeads > 0 ? round(($enrolledLeads / $totalLeads) * 100, 1) : 0;

        $revenueCollected = (float)(Database::fetchOne("SELECT SUM(amount) as s FROM payments WHERE status = 'completed' AND tenant_id = :tid", ['tid' => $tid])['s'] ?? 0);
        $pendingPayments = (float)(Database::fetchOne("SELECT SUM(amount) as s FROM payment_links WHERE status = 'active' AND tenant_id = :tid", ['tid' => $tid])['s'] ?? 0);

        // Funnel Breakdown
        $stages = [
            'new' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'new' AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0),
            'contacted' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'contacted' AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0),
            'qualified' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'qualified' AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0),
            'nurturing' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'nurturing' AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0),
            'application_sent' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'application_sent' AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0),
            'payment_link_generated' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'payment_link_generated' AND tenant_id = :tid", ['tid' => $tid])['c'] ?? 0),
            'enrolled' => $enrolledLeads,
            'lost' => $lostLeads
        ];

        // Channel ROI / Source breakdown
        $sourceBreakdown = Database::fetchAll("SELECT source, COUNT(*) as lead_count, 
                                                SUM(CASE WHEN status = 'enrolled' THEN 1 ELSE 0 END) as enrolled_count
                                                FROM leads WHERE tenant_id = :tid GROUP BY source ORDER BY lead_count DESC", ['tid' => $tid]);

        // Counselor Performance (Unique parameter names for native PDO prepared statement compatibility)
        $counselorPerformance = Database::fetchAll("SELECT u.id, u.first_name, u.last_name,
                                                     COUNT(l.id) as total_assigned,
                                                     SUM(CASE WHEN l.status != 'new' THEN 1 ELSE 0 END) as contacted_count,
                                                     SUM(CASE WHEN l.status = 'enrolled' THEN 1 ELSE 0 END) as enrolled_count,
                                                     SUM(CASE WHEN l.is_sla_breached = 1 THEN 1 ELSE 0 END) as sla_breaches
                                                     FROM users u
                                                     LEFT JOIN leads l ON l.counselor_id = u.id AND l.tenant_id = :tid1
                                                     WHERE u.tenant_id = :tid2
                                                     GROUP BY u.id
                                                     ORDER BY total_assigned DESC", ['tid1' => $tid, 'tid2' => $tid]);

        return [
            'total_leads' => $totalLeads,
            'new_leads' => $newLeads,
            'contacted_leads' => $contactedLeads,
            'contacted_pct' => $contactedPct,
            'enrolled_leads' => $enrolledLeads,
            'conversion_pct' => $conversionPct,
            'lost_leads' => $lostLeads,
            'sla_breaches' => $slaBreaches,
            'revenue_collected' => $revenueCollected,
            'pending_payments' => $pendingPayments,
            'stages' => $stages,
            'source_breakdown' => $sourceBreakdown,
            'counselor_performance' => $counselorPerformance
        ];
    }
}
