<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Tenant;
use App\Models\User;
use App\Services\PlanFeatureService;
use App\Helpers\Flash;
use App\Helpers\Security;

class TenantController extends Controller
{
    private Tenant $tenantModel;

    public function __construct()
    {
        parent::__construct();
        $this->tenantModel = new Tenant();
    }

    public function index(Request $request): void
    {
        $tenants = $this->tenantModel->all();
        $plans = PlanFeatureService::getPlans();

        $this->view('admin.tenants.index', [
            'tenants' => $tenants,
            'plans' => $plans,
            'title' => 'SaaS Pilot Client Academies'
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'name' => 'required|min:3',
            'subdomain' => 'required|min:3|alpha_dash',
            'admin_email' => 'required|email',
            'admin_password' => 'required|min:6',
            'plan_name' => 'required'
        ]);

        $subdomain = strtolower(trim($data['subdomain']));
        
        // Check if subdomain already exists
        if ($this->tenantModel->findBySubdomain($subdomain)) {
            Flash::error("Subdomain '{$subdomain}' is already taken by another pilot client.");
            $this->redirect('/admin/tenants');
            return;
        }

        // 1. Create Tenant Record
        $tenantId = $this->tenantModel->create([
            'name' => Security::sanitize($data['name']),
            'subdomain' => $subdomain,
            'email' => Security::sanitize($data['admin_email']),
            'status' => 'active',
            'plan_name' => Security::sanitize($data['plan_name']),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if ($tenantId) {
            // 2. Create Initial Admin User for this Tenant
            $userModel = new User();
            $hash = password_hash($data['admin_password'], PASSWORD_BCRYPT, ['cost' => 12]);
            
            $userId = $userModel->create([
                'tenant_id' => (int)$tenantId,
                'first_name' => Security::sanitize($data['name']),
                'last_name' => 'Admin',
                'email' => Security::sanitize($data['admin_email']),
                'password_hash' => $hash,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Assign Admin Role (Role ID 1) to user
            if ($userId) {
                \App\Core\Database::execute(
                    "INSERT INTO user_roles (user_id, role_id) VALUES (:uid, 1)",
                    ['uid' => (int)$userId]
                );
            }

            Flash::success("Pilot Client Academy '{$data['name']}' provisioned under {$data['plan_name']} tier!");
        } else {
            Flash::error("Failed to provision new pilot client academy.");
        }

        $this->redirect('/admin/tenants');
    }

    public function updatePlan(Request $request, string $id): void
    {
        $tenantId = (int)$id;
        $planName = Security::sanitize($request->get('plan_name', 'Bronze'));

        $updated = $this->tenantModel->update($tenantId, [
            'plan_name' => $planName,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($updated) {
            Flash::success("Updated Tenant #{$tenantId} subscription tier to {$planName}!");
        } else {
            Flash::error("Failed to update subscription tier.");
        }

        $this->redirect('/admin/tenants');
    }
}
