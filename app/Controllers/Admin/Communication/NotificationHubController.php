<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Communication;

use App\Core\Controller;
use App\Core\Request;
use App\Models\CommunicationLog;
use App\Models\NotificationTemplate;
use App\Services\CommunicationService;
use App\Helpers\Flash;
use App\Helpers\Url;

class NotificationHubController extends Controller
{
    public function index(Request $request): void
    {
        $logs = \App\Core\Database::fetchAll("SELECT * FROM communication_logs ORDER BY sent_at DESC LIMIT 50");
        $templates = (new NotificationTemplate())->all();

        $this->view('admin.communication.hub', [
            'pageTitle' => 'Communication & Notification Hub — Tyche Academy',
            'logs' => $logs,
            'templates' => $templates
        ], 'admin');
    }

    public function broadcast(Request $request): void
    {
        $data = $this->validate($request, [
            'channel' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $service = new CommunicationService();
        $service->dispatchNotification($data['channel'], 'All Active Students', $data['subject'], $data['message']);

        Flash::success("Broadcast notification dispatched over {$data['channel']}.");
        $this->redirect(Url::to('/admin/communication/hub'));
    }
}
