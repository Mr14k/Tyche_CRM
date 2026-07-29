<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    private NotificationService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new NotificationService();
    }

    public function index(Request $request): void
    {
        $user = Session::get('user');
        $notifications = $this->service->getUserNotifications((int)$user['id']);

        if ($request->isAjax()) {
            $this->json([
                'unread_count' => $this->service->getUnreadCount((int)$user['id']),
                'notifications' => $notifications
            ]);
        }

        $this->view('admin.notifications', [
            'pageTitle' => 'System Notifications — Tyche Academy',
            'notifications' => $notifications
        ], 'admin');
    }

    public function markAsRead(Request $request, string $id): void
    {
        $user = Session::get('user');
        $this->service->markAsRead((int)$id, (int)$user['id']);
        $this->json(['success' => true]);
    }
}
