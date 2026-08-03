<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Marketing;

use App\Core\Controller;
use App\Core\Request;
use App\Core\TenantContext;
use App\Models\TenantAdConnection;
use App\Helpers\Flash;
use App\Helpers\Url;

class AdIntegrationController extends Controller
{
    private TenantAdConnection $connectionModel;

    public function __construct()
    {
        parent::__construct();
        $this->connectionModel = new TenantAdConnection();
    }

    public function index(Request $request): void
    {
        $tenantId = TenantContext::getTenantId();
        $connections = $this->connectionModel->all();

        $metaConnections = array_filter($connections, fn($c) => $c['platform'] === 'meta');
        $googleConnections = array_filter($connections, fn($c) => $c['platform'] === 'google');

        $baseUrl = $_ENV['APP_URL'] ?? 'http://localhost/tyche';
        $metaWebhookUrl = rtrim($baseUrl, '/') . '/webhooks/meta/leadgen';
        $googleWebhookUrl = rtrim($baseUrl, '/') . '/webhooks/google/leadform';

        $this->view('admin.marketing.integrations', [
            'pageTitle' => 'Meta & Google Ads Lead Ingestion — Tyche Academy',
            'metaConnections' => $metaConnections,
            'googleConnections' => $googleConnections,
            'metaWebhookUrl' => $metaWebhookUrl,
            'googleWebhookUrl' => $googleWebhookUrl
        ], 'admin');
    }

    public function saveMeta(Request $request): void
    {
        $tenantId = TenantContext::getTenantId();
        $pageId = trim($request->input('page_id', ''));
        $accessToken = trim($request->input('access_token', ''));

        if (empty($pageId) || empty($accessToken)) {
            Flash::error("Facebook Page ID and Page Access Token are required.");
            $this->redirect(Url::to('/admin/marketing/integrations'));
            return;
        }

        $this->connectionModel->saveConnection($tenantId, 'meta', $pageId, $accessToken);

        Flash::success("Meta Business Page (ID: {$pageId}) connected successfully. Automated lead sync active.");
        $this->redirect(Url::to('/admin/marketing/integrations'));
    }

    public function saveGoogle(Request $request): void
    {
        $tenantId = TenantContext::getTenantId();
        $accountId = trim($request->input('account_id', ''));
        $webhookKey = trim($request->input('webhook_key', ''));

        if (empty($accountId) || empty($webhookKey)) {
            Flash::error("Google Ads Customer ID and Verification Key are required.");
            $this->redirect(Url::to('/admin/marketing/integrations'));
            return;
        }

        $this->connectionModel->saveConnection($tenantId, 'google', $webhookKey, $webhookKey, null, $webhookKey);

        Flash::success("Google Ads Customer Account ({$accountId}) connected successfully.");
        $this->redirect(Url::to('/admin/marketing/integrations'));
    }
}
