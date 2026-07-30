<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Core\TenantContext;
use App\Models\Tenant;

class PlanFeatureService
{
    private static array $plans = [
        'Bronze' => [
            'name' => 'Bronze Tier',
            'max_leads' => 100,
            'max_courses' => 5,
            'max_students' => 100,
            'modules' => ['crm', 'lms']
        ],
        'Silver' => [
            'name' => 'Silver Tier',
            'max_leads' => 1000,
            'max_courses' => 25,
            'max_students' => 1000,
            'modules' => ['crm', 'lms', 'bi', 'finance']
        ],
        'Gold' => [
            'name' => 'Gold Tier',
            'max_leads' => 10000,
            'max_courses' => 100,
            'max_students' => 10000,
            'modules' => ['crm', 'lms', 'bi', 'finance', 'placement', 'automation']
        ],
        'Enterprise' => [
            'name' => 'Enterprise Tier',
            'max_leads' => -1,
            'max_courses' => -1,
            'max_students' => -1,
            'modules' => ['crm', 'lms', 'bi', 'finance', 'placement', 'automation', 'whitelabel']
        ]
    ];

    public static function getPlans(): array
    {
        return self::$plans;
    }

    public static function getTenantPlan(?int $tenantId = null): array
    {
        $id = $tenantId ?? TenantContext::getTenantId();
        $tenantModel = new Tenant();
        $tenant = $tenantModel->find($id);

        $planName = $tenant['plan_name'] ?? 'Bronze';
        
        // Match plan or fallback to Bronze
        foreach (self::$plans as $key => $plan) {
            if (strcasecmp($key, $planName) === 0 || str_contains(strtolower($planName), strtolower($key))) {
                return array_merge(['plan_key' => $key], $plan);
            }
        }

        return array_merge(['plan_key' => 'Bronze'], self::$plans['Bronze']);
    }

    public static function checkLimit(string $limitType, ?int $tenantId = null): array
    {
        $id = $tenantId ?? TenantContext::getTenantId();
        $plan = self::getTenantPlan($id);

        $max = $plan[$limitType] ?? -1;
        if ($max === -1) {
            return ['allowed' => true, 'current' => 0, 'max' => 'Unlimited', 'plan' => $plan['name']];
        }

        $current = 0;
        if ($limitType === 'max_leads') {
            $row = Database::fetchOne("SELECT COUNT(*) as cnt FROM leads WHERE tenant_id = :tid", ['tid' => $id]);
            $current = (int)($row['cnt'] ?? 0);
        } elseif ($limitType === 'max_courses') {
            $row = Database::fetchOne("SELECT COUNT(*) as cnt FROM courses WHERE tenant_id = :tid", ['tid' => $id]);
            $current = (int)($row['cnt'] ?? 0);
        } elseif ($limitType === 'max_students') {
            $row = Database::fetchOne("SELECT COUNT(*) as cnt FROM users WHERE tenant_id = :tid", ['tid' => $id]);
            $current = (int)($row['cnt'] ?? 0);
        }

        $allowed = $current < $max;

        return [
            'allowed' => $allowed,
            'current' => $current,
            'max' => $max,
            'plan' => $plan['name'],
            'message' => $allowed ? '' : "Subscription Limit Reached: Your {$plan['name']} allows up to {$max} {$limitType} (Current usage: {$current}). Upgrade to a higher tier to continue."
        ];
    }

    public static function hasModuleAccess(string $moduleKey, ?int $tenantId = null): bool
    {
        $id = $tenantId ?? TenantContext::getTenantId();
        $tenantModel = new Tenant();
        $tenant = $tenantModel->find($id);

        if ($tenant && !empty($tenant['modules'])) {
            $customModules = json_decode($tenant['modules'], true);
            if (is_array($customModules)) {
                return in_array(strtolower($moduleKey), array_map('strtolower', $customModules), true);
            }
        }

        $plan = self::getTenantPlan($id);
        return in_array(strtolower($moduleKey), $plan['modules'], true) || $plan['plan_key'] === 'Enterprise';
    }

    public static function getTenantUsageStats(int $tenantId): array
    {
        $plan = self::getTenantPlan($tenantId);
        $leadLimit = self::checkLimit('max_leads', $tenantId);
        $courseLimit = self::checkLimit('max_courses', $tenantId);
        $studentLimit = self::checkLimit('max_students', $tenantId);
        
        $revenue = (float)(Database::fetchOne("SELECT SUM(amount) as total FROM payments WHERE status = 'completed' AND tenant_id = :tid", ['tid' => $tenantId])['total'] ?? 0);

        return [
            'plan' => $plan,
            'leads' => $leadLimit,
            'courses' => $courseLimit,
            'students' => $studentLimit,
            'total_revenue' => $revenue
        ];
    }
}
