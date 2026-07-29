<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Database;
use App\Models\PaymentLink;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\Payment;
use App\Models\Invoice;

class CrmPaymentLinkService extends Service
{
    private PaymentLink $linkModel;
    private Lead $leadModel;
    private LeadActivity $activityModel;

    public function __construct()
    {
        $this->linkModel = new PaymentLink();
        $this->leadModel = new Lead();
        $this->activityModel = new LeadActivity();
    }

    public function generatePaymentLink(int $leadId, int $courseId, ?int $batchId, float $amount, ?int $counselorId = null): array
    {
        $linkCode = 'PAYLINK-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 8));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));
        $paymentUrl = \App\Helpers\Url::to('/pay/' . $linkCode);

        $id = $this->linkModel->create([
            'link_code' => $linkCode,
            'lead_id' => $leadId,
            'course_id' => $courseId,
            'batch_id' => $batchId,
            'amount' => $amount,
            'gateway' => 'razorpay',
            'payment_url' => $paymentUrl,
            'expires_at' => $expiresAt,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Update lead status to payment_link_generated
        $this->leadModel->update($leadId, [
            'status' => 'payment_link_generated',
            'batch_id' => $batchId,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Log timeline activity
        $this->activityModel->create([
            'lead_id' => $leadId,
            'user_id' => $counselorId ?? 1,
            'type' => 'payment_link',
            'outcome' => 'sent',
            'notes' => "Generated 18% GST Payment Link of ₹" . number_format($amount, 2) . " for Course ID {$courseId}. Code: {$linkCode}",
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return [
            'payment_link_id' => (int)$id,
            'link_code' => $linkCode,
            'payment_url' => $paymentUrl,
            'amount' => $amount,
            'expires_at' => $expiresAt
        ];
    }

    public function completePaymentAndEnroll(string $linkCode, string $paymentReference, string $gateway = 'razorpay'): array
    {
        $link = $this->linkModel->findByCode($linkCode);
        if (!$link || $link['status'] === 'paid') {
            throw new \Exception("Payment link is invalid or has already been paid.");
        }

        $leadId = (int)$link['lead_id'];
        $courseId = (int)$link['course_id'];
        $batchId = !empty($link['batch_id']) ? (int)$link['batch_id'] : null;
        $amount = (float)$link['amount'];

        // 1. Mark payment link as paid
        $this->linkModel->update((int)$link['id'], [
            'status' => 'paid',
            'paid_at' => date('Y-m-d H:i:s')
        ]);

        // 2. Check if student user exists or create student user
        $user = Database::fetchOne("SELECT * FROM users WHERE email = :email LIMIT 1", ['email' => $link['email']]);
        if (!$user) {
            $authService = new AuthService();
            $regData = $authService->registerStudent([
                'first_name' => $link['first_name'],
                'last_name' => $link['last_name'],
                'email' => $link['email'],
                'phone' => $link['phone'],
                'password' => 'TycheStudent@2026'
            ], '127.0.0.1', 'CRM Payment Link Webhook');
            $userId = (int)($regData['id'] ?? $regData['user_id'] ?? 1);
        } else {
            $userId = (int)$user['id'];
        }

        // 3. Record Payment transaction
        $paymentModel = new Payment();
        $paymentId = $paymentModel->create([
            'admission_id' => null,
            'user_id' => $userId,
            'course_id' => $courseId,
            'payment_reference' => $paymentReference,
            'amount' => $amount,
            'gateway' => $gateway,
            'transaction_id' => 'TXN-' . date('YmdHis') . '-' . rand(1000, 9999),
            'status' => 'completed',
            'payment_date' => date('Y-m-d H:i:s')
        ]);



        // 4. Generate statutory 18% GST invoice
        $subtotal = round($amount / 1.18, 2);
        $gstAmount = round($amount - $subtotal, 2);
        $cgst = round($gstAmount / 2, 2);
        $sgst = round($gstAmount - $cgst, 2);

        $invoiceModel = new Invoice();
        $invoiceNumber = 'TYCHE-INV-' . date('Y') . '-' . sprintf('%06d', rand(1000, 999999));
        $invoiceModel->create([
            'invoice_number' => $invoiceNumber,
            'user_id' => $userId,
            'payment_id' => $paymentId,
            'subtotal' => $subtotal,
            'cgst_amount' => $cgst,
            'sgst_amount' => $sgst,
            'total_amount' => $amount,
            'issued_at' => date('Y-m-d H:i:s')
        ]);


        // 5. Update Lead status to 'enrolled'
        $this->leadModel->update($leadId, [
            'status' => 'enrolled',
            'lead_score' => 100,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // 6. Log activity timeline
        $this->activityModel->create([
            'lead_id' => $leadId,
            'user_id' => null,
            'type' => 'stage_change',
            'outcome' => 'converted',
            'notes' => "Payment of ₹" . number_format($amount, 2) . " received successfully. Lead status updated to ENROLLED. Student ID #{$userId} created.",
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 7. Update batch seat count if batch specified
        if ($batchId) {
            Database::execute("UPDATE batches SET seats_filled = seats_filled + 1 WHERE id = :id", ['id' => $batchId]);
        }

        return [
            'success' => true,
            'user_id' => $userId,
            'payment_id' => (int)$paymentId,
            'invoice_number' => $invoiceNumber
        ];
    }
}
