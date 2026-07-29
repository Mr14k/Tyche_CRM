<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Core\Request;
use App\Services\AuthService;
use App\Services\RbacService;
use App\Helpers\Flash;
use App\Helpers\Url;

class LoginController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new AuthService();
    }

    public function showLogin(Request $request): void
    {
        $this->view('auth.login', [
            'pageTitle' => 'Sign In — Tyche Academy'
        ], 'auth');
    }

    public function processLogin(Request $request): void
    {
        $data = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = $this->authService->attempt(
            $data['email'],
            $data['password'],
            $request->ip(),
            $request->userAgent()
        );

        Flash::success("Welcome back, {$user['first_name']}!");

        if (!RbacService::hasRole('Admin') && RbacService::hasPermission('STUDENT.Portal')) {
            $this->redirect(Url::to('/student/dashboard'));
            return;
        }

        if (!RbacService::hasRole('Admin') && RbacService::hasPermission('FACULTY.Workspace')) {
            $this->redirect(Url::to('/faculty/dashboard'));
            return;
        }

        $this->redirect(Url::to('/dashboard'));
    }

    public function logout(Request $request): void
    {
        $this->authService->logout($request->ip());
        Flash::info('You have been signed out successfully.');
        $this->redirect(Url::to('/login'));
    }
}
