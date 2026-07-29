<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Database;

class CrmTelemetryService extends Service
{
    public function getExecutiveMetrics(): array
    {
        $totalLeads = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads")['c'] ?? 0);
        $newLeads = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'new'")['c'] ?? 0);
        $contactedLeads = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status NOT IN ('new')")['c'] ?? 0);
        $enrolledLeads = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'enrolled'")['c'] ?? 0);
        $lostLeads = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'lost'")['c'] ?? 0);
        $slaBreaches = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE is_sla_breached = 1")['c'] ?? 0);

        $contactedPct = $totalLeads > 0 ? round(($contactedLeads / $totalLeads) * 100, 1) : 0;
        $conversionPct = $totalLeads > 0 ? round(($enrolledLeads / $totalLeads) * 100, 1) : 0;

        $revenueCollected = (float)(Database::fetchOne("SELECT SUM(amount) as s FROM payments WHERE status = 'completed'")['s'] ?? 0);
        $pendingPayments = (float)(Database::fetchOne("SELECT SUM(amount) as s FROM payment_links WHERE status = 'active'")['s'] ?? 0);

        // Funnel Breakdown
        $stages = [
            'new' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'new'")['c'] ?? 0),
            'contacted' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'contacted'")['c'] ?? 0),
            'qualified' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'qualified'")['c'] ?? 0),
            'nurturing' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'nurturing'")['c'] ?? 0),
            'application_sent' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'application_sent'")['c'] ?? 0),
            'payment_link_generated' => (int)(Database::fetchOne("SELECT COUNT(*) as c FROM leads WHERE status = 'payment_link_generated'")['c'] ?? 0),
            'enrolled' => $enrolledLeads,
            'lost' => $lostLeads
        ];

        // Channel ROI / Source breakdown
        $sourceBreakdown = Database::fetchAll("SELECT source, COUNT(*) as lead_count, 
                                                SUM(CASE WHEN status = 'enrolled' THEN 1 ELSE 0 END) as enrolled_count
                                                FROM leads GROUP BY source ORDER BY lead_count DESC");

        // Counselor Performance
        $counselorPerformance = Database::fetchAll("SELECT u.id, u.first_name, u.last_name,
                                                     COUNT(l.id) as total_assigned,
                                                     SUM(CASE WHEN l.status != 'new' THEN 1 ELSE 0 END) as contacted_count,
                                                     SUM(CASE WHEN l.status = 'enrolled' THEN 1 ELSE 0 END) as enrolled_count,
                                                     SUM(CASE WHEN l.is_sla_breached = 1 THEN 1 ELSE 0 END) as sla_breaches
                                                     FROM users u
                                                     LEFT JOIN leads l ON l.counselor_id = u.id
                                                     GROUP BY u.id
                                                     ORDER BY total_assigned DESC");


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
