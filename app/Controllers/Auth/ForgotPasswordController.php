<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Core\Request;
use App\Services\AuthService;
use App\Helpers\Flash;
use App\Helpers\Url;

class ForgotPasswordController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new AuthService();
    }

    public function showForgot(Request $request): void
    {
        $this->view('auth.forgot', [
            'pageTitle' => 'Forgot Password — Tyche Academy'
        ], 'auth');
    }

    public function processForgot(Request $request): void
    {
        $data = $this->validate($request, [
            'email' => 'required|email'
        ]);

        $this->authService->sendPasswordResetLink($data['email']);
        Flash::success('If an account exists for that email, password reset instructions have been dispatched.');
        $this->redirect(Url::to('/forgot-password'));
    }

    public function showReset(Request $request): void
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            Flash::error('Invalid password reset URL parameters.');
            $this->redirect(Url::to('/login'));
        }

        $this->view('auth.reset', [
            'pageTitle' => 'Set New Password — Tyche Academy',
            'token' => $token,
            'email' => $email
        ], 'auth');
    }

    public function processReset(Request $request): void
    {
        $data = $this->validate($request, [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8',
            'password_confirm' => 'required|matches:password'
        ]);

        $this->authService->resetPassword($data['email'], $data['token'], $data['password']);
        Flash::success('Password updated successfully! Please sign in with your new credentials.');
        $this->redirect(Url::to('/login'));
    }
}
