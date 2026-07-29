<?php
// Uses layouts/web.php
?>

<div class="hero-light py-5">
    <div class="container py-2 text-center">
        <span class="badge-pill-accent mb-2"><i class="bi bi-receipt me-1"></i> STATUTORY TAX VERIFICATION</span>
        <h1 class="display-5 font-heading fw-extrabold text-slate-900 mb-3">18% GST Invoice Lookup & Verification</h1>
        <p class="lead text-slate-600 mb-4 mx-auto" style="max-width: 640px;">
            Verify statutory tax compliance, invoice details, subtotal calculations, and SAC Code 999293 credentials.
        </p>

        <!-- Search Form -->
        <div class="max-w-2xl mx-auto p-3 bg-white rounded-4 border border-slate-200 shadow-lg" style="max-width: 640px;">
            <form action="<?= Url::to('/verify-invoice') ?>" method="GET" class="row g-2">
                <div class="col-8">
                    <input type="text" name="query" class="form-control form-control-lg font-monospace fs-6" placeholder="Enter Invoice No (TYCHE-INV-...) or Ref (PAY_...)" value="<?= Security::e($query ?? '') ?>" required>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary-edtech w-100 py-3 font-heading fw-bold">Verify Now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php if (!empty($searched)): ?>
                <?php if ($invoice): ?>
                    <!-- Verified Tax Invoice Card -->
                    <div class="card-edtech p-4 p-md-5 bg-white border-success shadow-lg">
                        <div class="d-flex justify-content-between align-items-start border-bottom border-slate-200 pb-4 mb-4">
                            <div>
                                <span class="badge bg-success text-white font-monospace px-3 py-2 rounded-pill mb-2"><i class="bi bi-check-circle-fill me-1"></i> VERIFIED STATUTORY GST RECEIPT</span>
                                <h3 class="h4 font-heading fw-bold text-slate-900 mb-1">Tyche Digital Marketing Academy</h3>
                                <div class="small text-slate-500 font-monospace">GSTIN: 07AAAAA0000A1Z5 | SAC Code: 999293</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold font-monospace text-slate-900 fs-5"><?= Security::e($invoice['invoice_number']) ?></div>
                                <div class="small text-slate-500">Issued: <?= Format::date($invoice['issued_at'], 'd M Y') ?></div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4 p-3 bg-slate-50 rounded-3 border border-slate-200 font-monospace small">
                            <div class="col-6">
                                <div class="text-slate-500">Student Billed:</div>
                                <div class="fw-bold text-slate-900"><?= Security::e($invoice['first_name'] . ' ' . $invoice['last_name']) ?></div>
                                <div class="text-slate-500"><?= Security::e($invoice['email']) ?></div>
                            </div>
                            <div class="col-6 text-end">
                                <div class="text-slate-500">Payment Reference:</div>
                                <div class="fw-bold text-primary"><?= Security::e($invoice['payment_reference']) ?></div>
                                <div class="text-slate-500">Gateway: <?= strtoupper(Security::e($invoice['gateway'])) ?></div>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-3 border border-slate-200 font-monospace small mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-slate-600">Base Tuition Subtotal:</span>
                                <span class="fw-bold text-slate-900">₹ <?= number_format((float)$invoice['subtotal'], 2) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-slate-600">Central GST (CGST 9%):</span>
                                <span class="text-slate-900">₹ <?= number_format((float)$invoice['cgst_amount'], 2) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-slate-600">State GST (SGST 9%):</span>
                                <span class="text-slate-900">₹ <?= number_format((float)$invoice['sgst_amount'], 2) ?></span>
                            </div>
                            <hr class="my-2 border-slate-200">
                            <div class="d-flex justify-content-between fs-6 fw-bold">
                                <span class="text-slate-900">Total Tax Inclusive Amount:</span>
                                <span class="text-primary fs-5">₹ <?= number_format((float)$invoice['total_amount'], 2) ?></span>
                            </div>
                        </div>

                        <div class="text-center text-slate-500 small">
                            <i class="bi bi-shield-check text-success me-1"></i> Computer-generated 18% GST invoice verified against Tyche Academy Tax Ledger.
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card-edtech p-5 bg-white border-danger text-center">
                        <i class="bi bi-exclamation-triangle-fill text-danger display-5 mb-3"></i>
                        <h4 class="h5 font-heading fw-bold text-slate-900">No GST Invoice Record Found</h4>
                        <p class="text-slate-600 small mb-0">No statutory tax invoice matching '<?= Security::e($query) ?>' was found in our ledger. Please verify your invoice number or payment reference.</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="p-4 bg-white rounded-4 border border-slate-200 text-center">
                    <p class="text-slate-600 m-0">Enter your official Invoice Number (e.g. <code>TYCHE-INV-2026-...</code>) or Payment Reference to verify tax details.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
