<?php

declare(strict_types=1);

namespace App\Controllers\Account;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\User;
use App\Services\UploadService;
use App\Helpers\Security;
use App\Helpers\Flash;
use App\Helpers\Url;
use App\Models\ActivityLog;

class ProfileController extends Controller
{
    private User $userModel;
    private UploadService $uploadService;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->uploadService = new UploadService();
    }

    public function showProfile(Request $request): void
    {
        $sessionUser = Session::get('user');
        $user = $this->userModel->find((int)$sessionUser['id']);

        $this->view('account.profile', [
            'pageTitle' => 'My Profile & Account Settings — Tyche Academy',
            'user' => $user
        ], 'admin');
    }

    public function updateProfile(Request $request): void
    {
        $sessionUser = Session::get('user');
        $data = $this->validate($request, [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'phone' => 'required'
        ]);

        $this->userModel->update((int)$sessionUser['id'], [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone']
        ]);

        // Refresh Session Data
        $sessionUser['first_name'] = $data['first_name'];
        $sessionUser['last_name'] = $data['last_name'];
        Session::set('user', $sessionUser);

        (new ActivityLog())->record((int)$sessionUser['id'], 'ACCOUNT', 'UPDATE_PROFILE', 'Updated profile details', $request->ip());
        Flash::success('Your profile details have been updated.');
        $this->redirect(Url::to('/account/profile'));
    }

    public function updateAvatar(Request $request): void
    {
        $sessionUser = Session::get('user');
        $file = $request->file('avatar');

        if (!$file) {
            Flash::error('Please select an image file to upload.');
            $this->redirect(Url::to('/account/profile'));
        }

        $avatarPath = $this->uploadService->uploadAvatar($file);
        $this->userModel->update((int)$sessionUser['id'], ['avatar' => $avatarPath]);

        $sessionUser['avatar'] = $avatarPath;
        Session::set('user', $sessionUser);

        (new ActivityLog())->record((int)$sessionUser['id'], 'ACCOUNT', 'UPDATE_AVATAR', 'Updated profile picture', $request->ip());
        Flash::success('Profile picture updated successfully.');
        $this->redirect(Url::to('/account/profile'));
    }

    public function changePassword(Request $request): void
    {
        $sessionUser = Session::get('user');
        $data = $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'new_password_confirm' => 'required|matches:new_password'
        ]);

        $user = $this->userModel->find((int)$sessionUser['id']);
        if (!Security::verifyPassword($data['current_password'], $user['password_hash'])) {
            Flash::error('Current password provided is incorrect.');
            $this->redirect(Url::to('/account/profile'));
        }

        $this->userModel->update((int)$sessionUser['id'], [
            'password_hash' => Security::hashPassword($data['new_password'])
        ]);

        (new ActivityLog())->record((int)$sessionUser['id'], 'ACCOUNT', 'CHANGE_PASSWORD', 'Changed account password', $request->ip());
        Flash::success('Your account password has been changed successfully.');
        $this->redirect(Url::to('/account/profile'));
    }
}
