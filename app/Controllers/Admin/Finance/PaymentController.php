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
}
