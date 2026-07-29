<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Helpers\Flash;
use App\Helpers\Url;
use App\Models\ActivityLog;

class RoleManagementController extends Controller
{
    private Role $roleModel;
    private Permission $permModel;

    public function __construct()
    {
        parent::__construct();
        $this->roleModel = new Role();
        $this->permModel = new Permission();
    }

    public function index(Request $request): void
    {
        $roles = $this->roleModel->all();
        $permissionsGrouped = $this->permModel->getAllGroupedByModule();

        foreach ($roles as &$r) {
            $r['permissions'] = array_column($this->roleModel->getPermissions((int)$r['id']), 'id');
        }

        $this->view('admin.roles', [
            'pageTitle' => 'Role & Permission Matrix — Tyche Academy',
            'roles' => $roles,
            'permissionsGrouped' => $permissionsGrouped
        ], 'admin');
    }

    public function updateMatrix(Request $request): void
    {
        $matrix = $request->input('matrix', []); // array of role_id => [permission_ids]

        foreach ($matrix as $roleId => $permIds) {
            $this->roleModel->syncPermissions((int)$roleId, is_array($permIds) ? $permIds : []);
        }

        (new ActivityLog())->record(
            (int)$_SESSION['user']['id'],
            'RBAC',
            'UPDATE_MATRIX',
            'Updated role permission matrix definitions',
            $request->ip()
        );

        Flash::success('Role Permission Matrix updated successfully.');
        $this->redirect(Url::to('/admin/roles'));
    }
}
