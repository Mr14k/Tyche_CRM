<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Models\Invoice;

class InvoiceService extends Service
{
    private Invoice $invoiceModel;

    public function __construct()
    {
        $this->invoiceModel = new Invoice();
    }

    public function generateGstInvoice(int $paymentId, int $userId, float $totalAmount): array
    {
        // 18% GST Calculation (Subtotal = Total / 1.18)
        $subtotal = round($totalAmount / 1.18, 2);
        $taxAmount = round($totalAmount - $subtotal, 2);
        $cgst = round($taxAmount / 2, 2);
        $sgst = round($taxAmount - $cgst, 2);

        $invoiceNumber = 'TYCHE-INV-' . date('Y') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));

        $invoiceId = $this->invoiceModel->create([
            'invoice_number' => $invoiceNumber,
            'payment_id' => $paymentId,
            'user_id' => $userId,
            'subtotal' => $subtotal,
            'cgst_amount' => $cgst,
            'sgst_amount' => $sgst,
            'total_amount' => $totalAmount,
            'issued_at' => date('Y-m-d H:i:s')
        ]);

        return [
            'invoice_id' => (int)$invoiceId,
            'invoice_number' => $invoiceNumber,
            'subtotal' => $subtotal,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'total' => $totalAmount
        ];
    }
}
