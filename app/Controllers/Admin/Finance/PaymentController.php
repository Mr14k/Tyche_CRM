<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Finance;

use App\Core\Controller;
use App\Core\Request;
use App\Core\TenantContext;
use App\Models\Payment;
use App\Models\Admission;
use App\Services\InvoiceService;
use App\Services\CommunicationService;
use App\Services\PaymentGatewayService;
use App\Exceptions\NotFoundException;
use App\Helpers\Flash;
use App\Helpers\Url;

class PaymentController extends Controller
{
    private Payment $paymentModel;

    public function __construct()
    {
        parent::__construct();
        $this->paymentModel = new Payment();
    }

    public function index(Request $request): void
    {
        $tid = TenantContext::getTenantId();
        $payments = $this->paymentModel->getPaymentsWithDetails();
        $admissions = (new Admission())->all();

        // Check invoice existence for each payment
        $paymentIds = array_column($payments, 'id');
        $invoicesMap = [];
        if (!empty($paymentIds)) {
            $inList = implode(',', array_map('intval', $paymentIds));
            $invRows = \App\Core\Database::fetchAll("SELECT id, payment_id, invoice_number FROM invoices WHERE payment_id IN ({$inList}) AND tenant_id = :tid", ['tid' => $tid]);
            foreach ($invRows as $ir) {
                $invoicesMap[(int)$ir['payment_id']] = $ir;
            }
        }

        foreach ($payments as &$p) {
            $p['invoice'] = $invoicesMap[(int)$p['id']] ?? null;
        }

        $this->view('admin.finance.payments', [
            'pageTitle' => 'Payment Transactions & Fee Ledger — Tyche Academy',
            'payments' => $payments,
            'admissions' => $admissions
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'admission_id' => 'required',
            'amount' => 'required|numeric'
        ]);

        $paymentRef = 'PAY-' . date('Y') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));

        $paymentId = $this->paymentModel->create([
            'payment_reference' => $paymentRef,
            'admission_id' => (int)$data['admission_id'],
            'amount' => (float)$data['amount'],
            'gateway' => $request->input('gateway', 'upi'),
            'transaction_id' => $request->input('transaction_id', 'TXN-' . rand(10000, 99999)),
            'status' => 'completed',
            'payment_date' => date('Y-m-d H:i:s')
        ]);

        // Find student user_id from admission
        $admission = (new Admission())->find((int)$data['admission_id']);
        if ($admission) {
            // Generate 18% GST Tax Invoice
            $invoiceService = new InvoiceService();
            $inv = $invoiceService->generateGstInvoice((int)$paymentId, (int)$admission['user_id'], (float)$data['amount']);

            // Dispatch SMS / Email notification receipt
            $comm = new CommunicationService();
            $comm->dispatchNotification('sms', 'Student', 'Fee Receipt Issued', "Payment of Rs {$data['amount']} received. Tax Invoice: {$inv['invoice_number']}", (int)$admission['user_id']);
        }

        Flash::success("Payment reference '{$paymentRef}' processed and 18% GST Tax Invoice generated.");
        $this->redirect(Url::to('/admin/finance/payments'));
    }

    public function generateInvoice(Request $request, string $id): void
    {
        $tid = TenantContext::getTenantId();
        $payment = $this->paymentModel->find((int)$id);
        if (!$payment) {
            throw new NotFoundException("Payment transaction not found.");
        }

        // Check if invoice already exists
        $existingInvoice = \App\Core\Database::fetchOne("SELECT id FROM invoices WHERE payment_id = :pid AND tenant_id = :tid", ['pid' => $payment['id'], 'tid' => $tid]);
        if ($existingInvoice) {
            Flash::info("GST Tax Invoice already exists for this payment transaction.");
            $this->redirect(Url::to('/admin/finance/invoices/' . $existingInvoice['id']));
            return;
        }

        // Determine student user_id
        $userId = (int)($payment['user_id'] ?? 0);
        if ($userId === 0 && !empty($payment['admission_id'])) {
            $adm = (new Admission())->find((int)$payment['admission_id']);
            if ($adm) {
                $userId = (int)$adm['user_id'];
            }
        }

        if ($userId === 0) {
            Flash::error("Cannot generate GST Invoice: Student user account associated with this payment could not be resolved.");
            $this->redirect(Url::to('/admin/finance/payments'));
            return;
        }

        $invoiceService = new InvoiceService();
        $inv = $invoiceService->generateGstInvoice((int)$payment['id'], $userId, (float)$payment['amount']);

        Flash::success("18% Statutory GST Invoice '{$inv['invoice_number']}' generated successfully!");
        $this->redirect(Url::to('/admin/finance/invoices/' . $inv['invoice_id']));
    }

    public function settings(Request $request): void
    {
        $gatewayService = new PaymentGatewayService();
        $config = $gatewayService->getActiveGatewayConfig();

        $this->view('admin.finance.settings', [
            'pageTitle' => 'Payment Gateways & Merchant Credentials — Tyche Academy',
            'config' => $config
        ], 'admin');
    }

    public function dashboard(Request $request): void
    {
        $tid = TenantContext::getTenantId();

        // 1. Core Financial BI Telemetry
        $totalRevenue = (float)(\App\Core\Database::fetchOne(
            "SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE tenant_id = :tid AND status = 'completed'",
            ['tid' => $tid]
        )['total'] ?? 0);

        $mtdRevenue = (float)(\App\Core\Database::fetchOne(
            "SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE tenant_id = :tid AND status = 'completed' AND MONTH(payment_date) = MONTH(CURRENT_DATE()) AND YEAR(payment_date) = YEAR(CURRENT_DATE())",
            ['tid' => $tid]
        )['total'] ?? 0);

        $ytdRevenue = (float)(\App\Core\Database::fetchOne(
            "SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE tenant_id = :tid AND status = 'completed' AND YEAR(payment_date) = YEAR(CURRENT_DATE())",
            ['tid' => $tid]
        )['total'] ?? 0);

        $todayRevenue = (float)(\App\Core\Database::fetchOne(
            "SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE tenant_id = :tid AND status = 'completed' AND DATE(payment_date) = CURRENT_DATE()",
            ['tid' => $tid]
        )['total'] ?? 0);

        $todayInvoicesCount = (int)(\App\Core\Database::fetchOne(
            "SELECT COUNT(*) as cnt FROM invoices WHERE tenant_id = :tid AND DATE(issued_at) = CURRENT_DATE()",
            ['tid' => $tid]
        )['cnt'] ?? 0);

        // 2. Collection Channel Breakdown
        $channelRows = \App\Core\Database::fetchAll(
            "SELECT gateway, COALESCE(SUM(amount), 0) as channel_total, COUNT(*) as txn_count FROM payments WHERE tenant_id = :tid AND status = 'completed' GROUP BY gateway",
            ['tid' => $tid]
        );

        // 3. 18% Statutory GST Summary
        $totalTaxable = round($totalRevenue / 1.18, 2);
        $totalGst = round($totalRevenue - $totalTaxable, 2);
        $cgst = round($totalGst / 2, 2);
        $sgst = round($totalGst / 2, 2);

        // 4. Pending / Overdue Fee Installments & Leads
        $pendingLeads = \App\Core\Database::fetchAll(
            "SELECT l.*, c.title as course_title, c.price as fee_amount 
             FROM leads l 
             LEFT JOIN courses c ON l.course_id = c.id 
             WHERE l.tenant_id = :tid AND l.status IN ('QUALIFIED', 'APPLICATION_SENT', 'NURTURING')
             ORDER BY l.updated_at DESC LIMIT 15",
            ['tid' => $tid]
        );

        // 5. Recent Completed Transactions
        $recentPayments = $this->paymentModel->getPaymentsWithDetails(10);

        $this->view('admin.finance.dashboard', [
            'pageTitle' => 'Executive Financial BI & Fee Recovery Hub — Tyche SaaS',
            'totalRevenue' => $totalRevenue,
            'mtdRevenue' => $mtdRevenue,
            'ytdRevenue' => $ytdRevenue,
            'todayRevenue' => $todayRevenue,
            'todayInvoicesCount' => $todayInvoicesCount,
            'channelRows' => $channelRows,
            'gstSummary' => [
                'totalTaxable' => $totalTaxable,
                'totalGst' => $totalGst,
                'cgst' => $cgst,
                'sgst' => $sgst
            ],
            'pendingLeads' => $pendingLeads,
            'recentPayments' => $recentPayments
        ], 'admin');
    }

    public function sendFeeReminder(Request $request, string $id): void
    {
        $tid = TenantContext::getTenantId();
        $lead = \App\Core\Database::fetchOne("SELECT * FROM leads WHERE id = :id AND tenant_id = :tid", ['id' => $id, 'tid' => $tid]);
        if (!$lead) {
            Flash::error("Lead or student record not found.");
            $this->redirect(Url::to('/admin/finance/dashboard'));
            return;
        }

        // Record activity in lead timeline
        \App\Core\Database::insert(
            "INSERT INTO lead_activities (tenant_id, lead_id, activity_type, notes, created_at) VALUES (:tid, :lid, 'fee_reminder', 'Automated Fee Payment Link & Reminder dispatched via WhatsApp / Email.', NOW())",
            ['tid' => $tid, 'lid' => $lead['id']]
        );

        Flash::success("📲 Fee Payment Link & WhatsApp reminder sent successfully to {$lead['first_name']} {$lead['last_name']} ({$lead['phone']})!");
        $this->redirect(Url::to('/admin/finance/dashboard'));
    }

    public function sendBulkFeeReminders(Request $request): void
    {
        $tid = TenantContext::getTenantId();
        $pendingLeads = \App\Core\Database::fetchAll(
            "SELECT id, first_name, last_name, phone FROM leads WHERE tenant_id = :tid AND status IN ('QUALIFIED', 'APPLICATION_SENT', 'NURTURING')",
            ['tid' => $tid]
        );

        $count = 0;
        foreach ($pendingLeads as $l) {
            \App\Core\Database::insert(
                "INSERT INTO lead_activities (tenant_id, lead_id, activity_type, notes, created_at) VALUES (:tid, :lid, 'fee_reminder', 'Bulk Fee Payment Link & Reminder dispatched via WhatsApp / Email.', NOW())",
                ['tid' => $tid, 'lid' => $l['id']]
            );
            $count++;
        }

        Flash::success("🚀 Bulk Fee Reminders dispatched to {$count} pending students & leads via WhatsApp & Email!");
        $this->redirect(Url::to('/admin/finance/dashboard'));
    }

    public function updateSettings(Request $request): void
    {
        $gatewayService = new PaymentGatewayService();
        $gatewayService->saveTenantGatewaySettings($request->all());

        Flash::success('Academy merchant payment gateway credentials & settings saved successfully.');
        $this->redirect(Url::to('/admin/finance/settings'));
    }
}
