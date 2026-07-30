<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\TenantContext;
use App\Models\Tenant;
use App\Models\SubscriptionPlan;
use App\Services\PlanFeatureService;
use App\Helpers\Flash;
use App\Helpers\Security;

class SubscriptionController extends Controller
{
    private Tenant $tenantModel;
    private SubscriptionPlan $planModel;

    public function __construct()
    {
        parent::__construct();
        $this->tenantModel = new Tenant();
        $this->planModel = new SubscriptionPlan();
    }

    private function enforceSuperAdminAccess(): bool
    {
        $user = Session::get('user');
        if (($user['tenant_id'] ?? 1) !== 1 || TenantContext::getTenantId() !== 1) {
            Flash::error("Access Denied: Super SaaS Admin privileges required to manage subscriptions.");
            $this->redirect('/admin/dashboard');
            return false;
        }
        return true;
    }

    public function index(Request $request): void
    {
        if (!$this->enforceSuperAdminAccess()) {
            return;
        }

        $tenants = $this->tenantModel->all();
        $plans = PlanFeatureService::getPlans();
        
        $totalTenants = count($tenants);
        $activeTenants = 0;
        $mrr = 0.0;
        $tenantStats = [];
        $expiringTenants = [];

        $now = time();

        foreach ($tenants as $t) {
            if ($t['status'] === 'active') {
                $activeTenants++;
            }

            $stats = PlanFeatureService::getTenantUsageStats((int)$t['id']);
            $tenantStats[$t['id']] = $stats;
            
            // Monthly Recurring Revenue estimation
            $planPrice = (float)($stats['plan']['price'] ?? 0);
            $mrr += $planPrice;

            // Check expiration / renewal dates
            $expiresAt = !empty($t['subscription_expires_at']) ? strtotime($t['subscription_expires_at']) : ($now + (30 * 86400));
            $daysLeft = (int)ceil(($expiresAt - $now) / 86400);

            if ($daysLeft <= 14) {
                $expiringTenants[] = array_merge($t, [
                    'days_left' => $daysLeft,
                    'expires_formatted' => date('M d, Y', $expiresAt),
                    'plan_price' => $planPrice
                ]);
            }
        }

        $this->view('admin.subscriptions.index', [
            'pageTitle' => 'SaaS Subscription & Tier Manager — Tyche Admin',
            'tenants' => $tenants,
            'plans' => $plans,
            'totalTenants' => $totalTenants,
            'activeTenants' => $activeTenants,
            'mrr' => $mrr,
            'tenantStats' => $tenantStats,
            'expiringTenants' => $expiringTenants
        ], 'admin');
    }

    public function storePlan(Request $request): void
    {
        if (!$this->enforceSuperAdminAccess()) {
            return;
        }

        $data = $this->validate($request, [
            'plan_key' => 'required|alpha_dash',
            'name' => 'required|min:3',
            'price' => 'required'
        ]);

        $key = ucfirst(strtolower(trim($data['plan_key'])));
        if ($this->planModel->findByKey($key)) {
            Flash::error("Plan key '{$key}' already exists.");
            $this->redirect('/admin/subscriptions');
            return;
        }

        $modules = $request->get('modules', ['crm', 'lms']);
        if (!is_array($modules)) {
            $modules = ['crm', 'lms'];
        }

        $planId = $this->planModel->create([
            'plan_key' => $key,
            'name' => Security::sanitize($data['name']),
            'price' => (float)$data['price'],
            'billing_cycle' => Security::sanitize($request->get('billing_cycle', 'monthly')),
            'max_leads' => (int)$request->get('max_leads', 100),
            'max_courses' => (int)$request->get('max_courses', 5),
            'max_students' => (int)$request->get('max_students', 100),
            'modules' => json_encode(array_values($modules)),
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if ($planId) {
            Flash::success("Subscription Tier '{$data['name']}' created successfully!");
        } else {
            Flash::error("Failed to create subscription tier.");
        }

        $this->redirect('/admin/subscriptions');
    }

    public function updatePlan(Request $request, string $id): void
    {
        if (!$this->enforceSuperAdminAccess()) {
            return;
        }

        $planId = (int)$id;
        $modules = $request->get('modules', ['crm', 'lms']);
        if (!is_array($modules)) {
            $modules = ['crm', 'lms'];
        }

        $updated = $this->planModel->update($planId, [
            'name' => Security::sanitize($request->get('name', 'Tier')),
            'price' => (float)$request->get('price', 0),
            'billing_cycle' => Security::sanitize($request->get('billing_cycle', 'monthly')),
            'max_leads' => (int)$request->get('max_leads', 100),
            'max_courses' => (int)$request->get('max_courses', 5),
            'max_students' => (int)$request->get('max_students', 100),
            'modules' => json_encode(array_values($modules)),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($updated) {
            Flash::success("Updated Subscription Plan #{$planId} settings & module limits!");
        } else {
            Flash::error("Failed to update subscription plan.");
        }

        $this->redirect('/admin/subscriptions');
    }

    public function sendRenewalReminder(Request $request, string $tenantId): void
    {
        if (!$this->enforceSuperAdminAccess()) {
            return;
        }

        $tId = (int)$tenantId;
        $tenant = $this->tenantModel->find($tId);

        if ($tenant) {
            // Trigger system notification
            $notifService = new \App\Services\NotificationService();
            $adminUser = \App\Core\Database::fetchOne("SELECT id FROM users WHERE tenant_id = :tid ORDER BY id ASC LIMIT 1", ['tid' => $tId]);
            
            if ($adminUser) {
                $notifService->sendNotification(
                    (int)$adminUser['id'],
                    "Subscription Renewal Reminder",
                    "Your academy's subscription plan is due for renewal soon. Please contact Super Admin to extend your plan.",
                    "/account/profile"
                );
            }

            Flash::success("Sent subscription renewal reminder to '{$tenant['name']}' (#{$tId})!");
        } else {
            Flash::error("Tenant not found.");
        }

        $this->redirect('/admin/subscriptions');
    }
}
