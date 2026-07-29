<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Finance;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Invoice;
use App\Exceptions\NotFoundException;

class InvoiceController extends Controller
{
    private Invoice $invoiceModel;

    public function __construct()
    {
        parent::__construct();
        $this->invoiceModel = new Invoice();
    }

    public function index(Request $request): void
    {
        $invoices = $this->invoiceModel->getInvoicesWithDetails();
        $this->view('admin.finance.invoices', [
            'pageTitle' => 'GST Tax Invoices & Tax Ledger — Tyche Academy',
            'invoices' => $invoices
        ], 'admin');
    }

    public function showInvoice(Request $request, string $id): void
    {
        $sql = "SELECT inv.*, u.first_name, u.last_name, u.email, p.payment_reference, p.gateway, p.payment_date, p.transaction_id
                FROM invoices inv
                JOIN users u ON inv.user_id = u.id
                JOIN payments p ON inv.payment_id = p.id
                WHERE inv.id = :id";
        $invoice = \App\Core\Database::fetchOne($sql, ['id' => (int)$id]);

        if (!$invoice) {
            throw new NotFoundException("GST Tax Invoice record not found.");
        }

        $this->view('admin.finance.invoice_view', [
            'pageTitle' => "GST Tax Invoice {$invoice['invoice_number']} — Tyche Academy",
            'inv' => $invoice
        ], 'admin');
    }
}
