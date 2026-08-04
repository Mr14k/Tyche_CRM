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

    public function recordOfflinePaymentAndEnroll(int $leadId, int $courseId, ?int $batchId, float $amount, string $paymentMethod = 'cash', ?string $referenceNumber = null, ?string $notes = null, ?int $counselorId = null): array
    {
        $lead = $this->leadModel->find($leadId);
        if (!$lead) {
            throw new \Exception("Lead record not found.");
        }

        $tid = \App\Core\TenantContext::getTenantId();
        $refNo = !empty($referenceNumber) ? trim($referenceNumber) : 'CASH-REC-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));

        // 1. Check if student user exists or create student user
        $user = Database::fetchOne("SELECT * FROM users WHERE email = :email AND tenant_id = :tid LIMIT 1", [
            'email' => $lead['email'],
            'tid' => $tid
        ]);

        if (!$user) {
            $authService = new AuthService();
            $regData = $authService->registerStudent([
                'first_name' => $lead['first_name'],
                'last_name' => $lead['last_name'],
                'email' => $lead['email'],
                'phone' => $lead['phone'],
                'password' => 'TycheStudent@2026'
            ], '127.0.0.1', 'CRM Manual Cash Payment');
            $userId = (int)($regData['id'] ?? $regData['user_id'] ?? 1);
        } else {
            $userId = (int)$user['id'];
        }

        // 2. Record Payment transaction
        $paymentModel = new Payment();
        $paymentId = $paymentModel->create([
            'tenant_id' => $tid,
            'admission_id' => null,
            'user_id' => $userId,
            'course_id' => $courseId,
            'payment_reference' => $refNo,
            'amount' => $amount,
            'gateway' => strtolower($paymentMethod),
            'transaction_id' => $refNo,
            'status' => 'completed',
            'payment_date' => date('Y-m-d H:i:s')
        ]);

        // 3. Generate statutory 18% GST invoice
        $subtotal = round($amount / 1.18, 2);
        $gstAmount = round($amount - $subtotal, 2);
        $cgst = round($gstAmount / 2, 2);
        $sgst = round($gstAmount - $cgst, 2);

        $invoiceModel = new Invoice();
        $invoiceNumber = 'TYCHE-INV-' . date('Y') . '-' . sprintf('%06d', rand(1000, 999999));
        $invoiceModel->create([
            'tenant_id' => $tid,
            'invoice_number' => $invoiceNumber,
            'user_id' => $userId,
            'payment_id' => $paymentId,
            'subtotal' => $subtotal,
            'cgst_amount' => $cgst,
            'sgst_amount' => $sgst,
            'total_amount' => $amount,
            'issued_at' => date('Y-m-d H:i:s')
        ]);

        // 4. Create or update course enrollment
        $existingEnroll = Database::fetchOne("SELECT id FROM course_enrollments WHERE tenant_id = :tid AND user_id = :uid AND course_id = :cid LIMIT 1", [
            'tid' => $tid,
            'uid' => $userId,
            'cid' => $courseId
        ]);
        if (!$existingEnroll) {
            Database::execute("INSERT INTO course_enrollments (tenant_id, user_id, course_id, status, enrolled_at) VALUES (:tid, :uid, :cid, 'active', NOW())", [
                'tid' => $tid,
                'uid' => $userId,
                'cid' => $courseId
            ]);
        }

        // 5. Update Lead status to 'enrolled'
        $this->leadModel->update($leadId, [
            'status' => 'enrolled',
            'batch_id' => $batchId,
            'lead_score' => 100,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // 6. Log activity timeline
        $methodLabel = strtoupper($paymentMethod);
        $this->activityModel->create([
            'tenant_id' => $tid,
            'lead_id' => $leadId,
            'user_id' => $counselorId ?? 1,
            'type' => 'payment_received',
            'outcome' => 'offline_cash_enrolled',
            'notes' => "Offline {$methodLabel} Payment of ₹" . number_format($amount, 2) . " received (Ref: {$refNo}). Student Account #{$userId} provisioned & Tax Invoice {$invoiceNumber} issued. Note: {$notes}",
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
            'invoice_number' => $invoiceNumber,
            'reference' => $refNo
        ];
    }
}
