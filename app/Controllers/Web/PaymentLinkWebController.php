<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Controller;
use App\Core\Request;
use App\Models\PaymentLink;
use App\Services\CrmPaymentLinkService;
use App\Exceptions\NotFoundException;
use App\Helpers\Flash;
use App\Helpers\Url;

class PaymentLinkWebController extends Controller
{
    private PaymentLink $linkModel;

    public function __construct()
    {
        parent::__construct();
        $this->linkModel = new PaymentLink();
    }

    public function show(Request $request, string $code): void
    {
        $link = $this->linkModel->findByCode($code);
        if (!$link) {
            throw new NotFoundException("Payment Link #{$code} not found or expired.");
        }

        $subtotal = round((float)$link['amount'] / 1.18, 2);
        $gst = round((float)$link['amount'] - $subtotal, 2);

        $this->view('web.payment_link', [
            'pageTitle' => "Statutory 18% GST Payment Checkout — Tyche Academy",
            'link' => $link,
            'subtotal' => $subtotal,
            'gst' => $gst
        ], 'web');
    }

    public function process(Request $request, string $code): void
    {
        $gateway = $request->input('gateway', 'razorpay');
        $paymentRef = 'PAYLINK-' . strtoupper(substr(md5(uniqid('', true)), 0, 10));

        $linkService = new CrmPaymentLinkService();
        $res = $linkService->completePaymentAndEnroll($code, $paymentRef, (string)$gateway);

        Flash::success("Payment completed successfully! Official 18% GST Invoice #{$res['invoice_number']} generated. Student enrollment active.");
        $this->redirect(Url::to('/student/dashboard'));
    }
}
