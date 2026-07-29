<div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Official 18% Statutory GST Tax Invoice</h2>
        <p class="text-secondary small m-0">Invoice No: <?= Security::e($inv['invoice_number']) ?></p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-gold btn-sm px-3 font-monospace">
            <i class="bi bi-printer-fill me-1"></i> Print / Save PDF
        </button>
        <a href="<?= Url::to('/admin/finance/payments') ?>" class="btn btn-outline-secondary btn-sm text-light font-monospace">
            <i class="bi bi-arrow-left me-1"></i> Fee Ledger
        </a>
    </div>
</div>

<div class="card p-5 shadow-lg rounded-3 border" id="invoicePrintArea" style="max-width: 900px; margin: 0 auto; background-color: #FFFFFF !important; color: #0F172A !important; border: 1px solid #CBD5E1 !important;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4" style="border-color: #E2E8F0 !important;">
        <div>
            <h2 class="h3 font-heading fw-extrabold m-0" style="color: #4F46E5 !important;">Tyche Digital Marketing Academy</h2>
            <div class="small fw-semibold mt-1" style="color: #475569 !important;">Innovation Tower, Cyber City, Gurugram, Haryana - 122002</div>
            <div class="small font-monospace fw-bold mt-1" style="color: #334155 !important;">GSTIN: 07AAAAA0000A1Z5 | SAC Code: 999293 (Educational Services)</div>
        </div>
        <div class="text-end">
            <span class="badge font-monospace px-3 py-2 fs-6 text-white" style="background-color: #4F46E5 !important;">TAX INVOICE</span>
            <div class="fw-bold font-monospace mt-2 fs-6" style="color: #0F172A !important;"><?= Security::e($inv['invoice_number']) ?></div>
            <div class="small font-semibold" style="color: #64748B !important;">Issued Date: <?= Format::date($inv['issued_at'], 'd M Y') ?></div>
        </div>
    </div>

    <!-- Billed To & Payment Details -->
    <div class="row g-4 mb-4 p-3 rounded-3" style="background-color: #F8FAFC !important; border: 1px solid #E2E8F0 !important;">
        <div class="col-6">
            <h6 class="fw-bold text-uppercase font-monospace small mb-2" style="color: #475569 !important;">Billed To (Student):</h6>
            <div class="fw-extrabold fs-6" style="color: #0F172A !important;"><?= Security::e($inv['first_name'] . ' ' . $inv['last_name']) ?></div>
            <div class="small font-monospace fw-semibold" style="color: #475569 !important;"><?= Security::e($inv['email']) ?></div>
        </div>
        <div class="col-6 text-end">
            <h6 class="fw-bold text-uppercase font-monospace small mb-2" style="color: #475569 !important;">Payment Details:</h6>
            <div class="small fw-semibold" style="color: #0F172A !important;">Payment Ref: <strong class="font-monospace" style="color: #4F46E5 !important;"><?= Security::e($inv['payment_reference']) ?></strong></div>
            <div class="small fw-semibold my-1" style="color: #0F172A !important;">Gateway: <span class="badge font-monospace text-white" style="background-color: #334155 !important;"><?= strtoupper($inv['gateway']) ?></span></div>
            <div class="small font-monospace fw-semibold" style="color: #64748B !important;">Txn ID: <?= Security::e($inv['transaction_id'] ?? 'N/A') ?></div>
        </div>
    </div>

    <!-- Itemized Tax Table -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered align-middle m-0" style="background-color: #FFFFFF !important; border-color: #CBD5E1 !important;">
            <thead>
                <tr style="background-color: #0F172A !important; color: #FFFFFF !important;">
                    <th style="background-color: #0F172A !important; color: #FFFFFF !important; padding: 12px 16px;">Description of Service</th>
                    <th class="text-center" style="background-color: #0F172A !important; color: #FFFFFF !important; padding: 12px 16px;">SAC Code</th>
                    <th class="text-end" style="background-color: #0F172A !important; color: #FFFFFF !important; padding: 12px 16px;">Base Subtotal</th>
                    <th class="text-end" style="background-color: #0F172A !important; color: #FFFFFF !important; padding: 12px 16px;">CGST (9%)</th>
                    <th class="text-end" style="background-color: #0F172A !important; color: #FFFFFF !important; padding: 12px 16px;">SGST (9%)</th>
                    <th class="text-end" style="background-color: #0F172A !important; color: #FFFFFF !important; padding: 12px 16px;">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="background-color: #FFFFFF !important; color: #0F172A !important; padding: 14px 16px;">
                        <div class="fw-bold" style="color: #0F172A !important;">Digital Marketing Academy Executive Mastery Tuition Fee</div>
                        <div class="small fw-semibold" style="color: #64748B !important;">Includes lifetime video access, capstone reviews & verified SHA-256 certificate</div>
                    </td>
                    <td class="text-center font-monospace small fw-bold" style="background-color: #FFFFFF !important; color: #0F172A !important; padding: 14px 16px;">999293</td>
                    <td class="text-end font-monospace fw-semibold" style="background-color: #FFFFFF !important; color: #0F172A !important; padding: 14px 16px;">₹ <?= number_format((float)$inv['subtotal'], 2) ?></td>
                    <td class="text-end font-monospace fw-semibold" style="background-color: #FFFFFF !important; color: #0F172A !important; padding: 14px 16px;">₹ <?= number_format((float)$inv['cgst_amount'], 2) ?></td>
                    <td class="text-end font-monospace fw-semibold" style="background-color: #FFFFFF !important; color: #0F172A !important; padding: 14px 16px;">₹ <?= number_format((float)$inv['sgst_amount'], 2) ?></td>
                    <td class="text-end font-monospace fw-bold" style="background-color: #FFFFFF !important; color: #4F46E5 !important; padding: 14px 16px; font-size: 16px;">₹ <?= number_format((float)$inv['total_amount'], 2) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Totals Summary -->
    <div class="row align-items-center justify-content-end mb-4">
        <div class="col-md-6 col-lg-5">
            <div class="p-3 rounded-3 font-monospace small" style="background-color: #F8FAFC !important; border: 1px solid #E2E8F0 !important;">
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: #475569 !important;">Tax Exclusive Subtotal:</span>
                    <span class="fw-bold" style="color: #0F172A !important;">₹ <?= number_format((float)$inv['subtotal'], 2) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: #475569 !important;">Central GST (CGST 9%):</span>
                    <span class="fw-bold" style="color: #0F172A !important;">₹ <?= number_format((float)$inv['cgst_amount'], 2) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: #475569 !important;">State GST (SGST 9%):</span>
                    <span class="fw-bold" style="color: #0F172A !important;">₹ <?= number_format((float)$inv['sgst_amount'], 2) ?></span>
                </div>
                <hr class="my-2" style="border-color: #CBD5E1 !important;">
                <div class="d-flex justify-content-between fw-bold fs-6" style="color: #0F172A !important;">
                    <span>Grand Total (Paid):</span>
                    <span class="fs-5 fw-extrabold" style="color: #4F46E5 !important;">₹ <?= number_format((float)$inv['total_amount'], 2) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Note -->
    <div class="pt-4 text-center small" style="border-top: 1px solid #E2E8F0 !important; color: #64748B !important;">
        <div class="fw-semibold">This is an official computer-generated statutory 18% GST Tax Invoice. No physical signature is required.</div>
        <div class="font-monospace fw-bold mt-1" style="color: #4F46E5 !important;">Tyche Digital Marketing Academy • www.tyche.academy</div>
    </div>
</div>
