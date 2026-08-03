<?php

declare(strict_types=1);

namespace App\Controllers\Webhooks;

use App\Core\Controller;
use App\Core\Request;
use App\Services\AdLeadIngestionService;

class AdWebhookController extends Controller
{
    private AdLeadIngestionService $ingestionService;

    public function __construct()
    {
        $this->ingestionService = new AdLeadIngestionService();
    }

    /**
     * Meta Webhook GET Challenge Verification
     */
    public function metaChallenge(Request $request): void
    {
        $verifyToken = $request->query('hub_verify_token', '');
        $challenge = $request->query('hub_challenge', '');
        $expectedToken = $_ENV['META_VERIFY_TOKEN'] ?? 'TycheMetaVerifyToken2026';

        if ($verifyToken === $expectedToken && !empty($challenge)) {
            header('Content-Type: text/plain');
            echo $challenge;
            exit;
        }

        http_response_code(403);
        echo "Forbidden: Verification Token Mismatch";
        exit;
    }

    /**
     * Meta Webhook POST Receiver
     */
    public function metaLeadgen(Request $request): void
    {
        $rawBody = file_get_contents('php://input') ?: '';
        $signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
        $appSecret = $_ENV['META_APP_SECRET'] ?? 'TycheMetaAppSecretKey';

        // Optional HMAC-SHA256 Signature Verification in Production
        if (!empty($signature) && !$this->ingestionService->verifyMetaSignature($rawBody, $signature, $appSecret)) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid HMAC-SHA256 signature']);
            exit;
        }

        $payload = json_decode($rawBody, true) ?? [];
        $result = $this->ingestionService->processMetaLeadgenPayload($payload);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    /**
     * Google Ads Webhook POST Receiver
     */
    public function googleLeadform(Request $request): void
    {
        $rawBody = file_get_contents('php://input') ?: '';
        $payload = json_decode($rawBody, true) ?? [];

        $result = $this->ingestionService->processGoogleAdsPayload($payload);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}
