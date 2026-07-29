<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Models\User;
use App\Models\Role;
use App\Helpers\Security;
use App\Helpers\Flash;
use App\Helpers\Url;
use App\Models\ActivityLog;

class UserManagementController extends Controller
{
    private User $userModel;
    private Role $roleModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->roleModel = new Role();
    }

    public function index(Request $request): void
    {
        $users = $this->userModel->all();
        foreach ($users as &$u) {
            $u['roles'] = $this->userModel->getRoles((int)$u['id']);
        }

        $roles = $this->roleModel->all();

        $this->view('admin.users', [
            'pageTitle' => 'User Accounts & Identity Directory — Tyche Academy',
            'users' => $users,
            'roles' => $roles
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|min:8',
            'role_id' => 'required'
        ]);

        $userId = $this->userModel->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => strtolower($data['email']),
            'phone' => $data['phone'],
            'password_hash' => Security::hashPassword($data['password']),
            'status' => 'active',
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);

        if ($userId) {
            $this->userModel->assignRole((int)$userId, (int)$data['role_id']);
            (new ActivityLog())->record(
                (int)($_SESSION['user']['id'] ?? 1),
                'USERS',
                'CREATE',
                "Created user account {$data['email']} with role ID {$data['role_id']}",
                $request->ip()
            );
            Flash::success("User account for {$data['first_name']} {$data['last_name']} created successfully.");
        }

        $this->redirect(Url::to('/admin/users'));
    }

    public function update(Request $request, string $id): void
    {
        $user = $this->userModel->find((int)$id);
        if (!$user) {
            Flash::error("User account not found.");
            $this->redirect(Url::to('/admin/users'));
            return;
        }

        $data = $this->validate($request, [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        $updateFields = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => strtolower($data['email']),
            'phone' => $data['phone'],
            'status' => $request->input('status', $user['status'])
        ];

        if (!empty($request->input('password'))) {
            $updateFields['password_hash'] = Security::hashPassword($request->input('password'));
        }

        $this->userModel->update((int)$id, $updateFields);

        if (!empty($request->input('role_id'))) {
            $this->userModel->syncRoles((int)$id, [(int)$request->input('role_id')]);
        }

        (new ActivityLog())->record(
            (int)($_SESSION['user']['id'] ?? 1),
            'USERS',
            'UPDATE',
            "Updated user account {$data['email']}",
            $request->ip()
        );

        Flash::success("User account for {$data['first_name']} {$data['last_name']} updated successfully.");
        $this->redirect(Url::to('/admin/users'));
    }

    public function toggleStatus(Request $request, string $id): void
    {
        $user = $this->userModel->find((int)$id);
        if ($user) {
            $newStatus = ($user['status'] === 'active') ? 'inactive' : 'active';
            $this->userModel->update((int)$id, ['status' => $newStatus]);
            
            Flash::success("Account status for {$user['first_name']} {$user['last_name']} set to " . strtoupper($newStatus) . ".");
        }
        $this->redirect(Url::to('/admin/users'));
    }

    public function delete(Request $request, string $id): void
    {
        $user = $this->userModel->find((int)$id);
        if ($user) {
            $this->userModel->delete((int)$id);
            Flash::success("User account for {$user['first_name']} {$user['last_name']} deleted.");
        }
        $this->redirect(Url::to('/admin/users'));
    }
}
