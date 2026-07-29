<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Session;
use App\Models\User;
use App\Models\LoginHistory;
use App\Models\PasswordReset;
use App\Models\UserSession;
use App\Models\ActivityLog;
use App\Helpers\Security;
use App\Helpers\Logger;
use App\Exceptions\ValidationException;

class AuthService extends Service
{
    private User $userModel;
    private LoginHistory $loginHistory;
    private PasswordReset $passwordReset;
    private UserSession $userSession;
    private ActivityLog $activityLog;

    public function __construct()
    {
        $this->userModel = new User();
        $this->loginHistory = new LoginHistory();
        $this->passwordReset = new PasswordReset();
        $this->userSession = new UserSession();
        $this->activityLog = new ActivityLog();
    }

    public function attempt(string $email, string $password, string $ip, ?string $userAgent): array
    {
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $this->loginHistory->record(null, $email, $ip, $userAgent, 'user_not_found');
            throw new ValidationException(['email' => ['Invalid credentials provided.']]);
        }

        // Check account lock
        if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
            $this->loginHistory->record((int)$user['id'], $email, $ip, $userAgent, 'account_locked');
            $remaining = ceil((strtotime($user['locked_until']) - time()) / 60);
            throw new ValidationException(['email' => ["Account is temporarily locked. Try again in {$remaining} minutes."]]);
        }

        // Verify status
        if ($user['status'] !== 'active') {
            throw new ValidationException(['email' => ['Your account is currently inactive or suspended.']]);
        }

        // Verify password
        if (!Security::verifyPassword($password, $user['password_hash'])) {
            $failedAttempts = (int)$user['failed_login_attempts'] + 1;
            $updateData = ['failed_login_attempts' => $failedAttempts];

            // Lock account after 5 consecutive failed attempts for 15 minutes
            if ($failedAttempts >= 5) {
                $updateData['locked_until'] = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            }

            $this->userModel->update((int)$user['id'], $updateData);
            $this->loginHistory->record((int)$user['id'], $email, $ip, $userAgent, 'failed_password');

            throw new ValidationException(['email' => ['Invalid credentials provided.']]);
        }

        // Reset failed login count upon success
        $this->userModel->update((int)$user['id'], [
            'failed_login_attempts' => 0,
            'locked_until' => null
        ]);

        $this->loginHistory->record((int)$user['id'], $email, $ip, $userAgent, 'success');

        // Log into session & regenerate session ID
        Session::regenerate();
        $roles = $this->userModel->getRoles((int)$user['id']);
        $permissions = $this->userModel->getPermissions((int)$user['id']);

        $sessionData = [
            'id' => (int)$user['id'],
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'avatar' => $user['avatar'],
            'roles' => array_column($roles, 'name'),
            'permissions' => $permissions
        ];

        Session::set('user', $sessionData);

        // Record User Session in DB
        $this->userSession->createOrUpdateSession(session_id(), (int)$user['id'], $ip, $userAgent);
        $this->activityLog->record((int)$user['id'], 'AUTH', 'LOGIN', 'User logged in successfully', $ip);

        return $sessionData;
    }

    public function registerStudent(array $data, string $ip, ?string $userAgent): array
    {
        $existing = $this->userModel->findByEmail($data['email']);
        if ($existing) {
            throw new ValidationException(['email' => ['An account with this email address already exists. Please sign in.']]);
        }

        $userId = (int)$this->userModel->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? '',
            'email' => strtolower(trim($data['email'])),
            'phone' => $data['phone'] ?? null,
            'password_hash' => Security::hashPassword($data['password']),
            'status' => 'active'
        ]);

        // Assign Student role (id 3 or lookup)
        $studentRole = \App\Core\Database::fetchOne("SELECT id FROM roles WHERE name = 'Student' LIMIT 1");
        if ($studentRole) {
            $this->userModel->assignRole($userId, (int)$studentRole['id']);
        }

        // Auto-login into session
        Session::regenerate();
        $roles = $this->userModel->getRoles($userId);
        $permissions = $this->userModel->getPermissions($userId);

        $sessionData = [
            'id' => $userId,
            'email' => strtolower(trim($data['email'])),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? '',
            'avatar' => null,
            'roles' => array_column($roles, 'name'),
            'permissions' => $permissions
        ];

        Session::set('user', $sessionData);
        $this->userSession->createOrUpdateSession(session_id(), $userId, $ip, $userAgent);
        $this->activityLog->record($userId, 'AUTH', 'REGISTER', 'Student self-registered account', $ip);

        return $sessionData;
    }

    public function logout(string $ip): void
    {
        $user = Session::get('user');
        if ($user) {
            $this->userSession->deleteSession(session_id());
            $this->activityLog->record((int)$user['id'], 'AUTH', 'LOGOUT', 'User logged out', $ip);
        }
        Session::destroy();
    }

    public function user(): ?array
    {
        return Session::get('user');
    }

    public function check(): bool
    {
        return Session::has('user');
    }

    public function sendPasswordResetLink(string $email): void
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            return;
        }

        $rawToken = Security::generateRandomToken(32);
        $tokenHash = hash('sha256', $rawToken);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->passwordReset->createToken($user['email'], $tokenHash, $expiresAt);

        $resetUrl = \App\Helpers\Url::to('/reset-password?token=' . $rawToken . '&email=' . urlencode($user['email']));
        $body = "<h2>Tyche Academy Password Reset</h2>
                 <p>Hi {$user['first_name']},</p>
                 <p>Click the link below to reset your account password. This link will expire in 60 minutes.</p>
                 <p><a href='{$resetUrl}'>{$resetUrl}</a></p>";

        MailService::send($user['email'], 'Reset Your Password — Tyche Academy', $body);
    }

    public function resetPassword(string $email, string $token, string $newPassword): void
    {
        $tokenHash = hash('sha256', $token);
        $resetRecord = $this->passwordReset->findValidToken($tokenHash);

        if (!$resetRecord || strtolower($resetRecord['email']) !== strtolower($email)) {
            throw new ValidationException(['token' => ['Invalid or expired password reset link.']]);
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            throw new ValidationException(['email' => ['User not found.']]);
        }

        $this->userModel->update((int)$user['id'], [
            'password_hash' => Security::hashPassword($newPassword),
            'failed_login_attempts' => 0,
            'locked_until' => null
        ]);

        $this->passwordReset->deleteForEmail($email);
        $this->activityLog->record((int)$user['id'], 'AUTH', 'PASSWORD_RESET', 'Password reset completed via token', $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
    }
}
