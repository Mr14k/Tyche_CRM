<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Payment Transactions & Fee Ledger</h2>
        <p class="text-secondary small m-0">Record online & offline tuition fee payments, manage ledger, and generate statutory 18% GST Tax Invoices</p>
    </div>
    <button class="btn btn-gold btn-sm px-3" data-bs-toggle="modal" data-bs-target="#recordPaymentModal">
        <i class="bi bi-credit-card-fill"></i> Record Fee Payment
    </button>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom align-middle m-0" style="background:#161F2B !important; color:#F3EEE2 !important;">
            <thead>
                <tr>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Payment Reference</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Student Name & Email</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Course Title</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Gateway</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Amount Paid</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Status</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Payment Date</th>
                    <th class="text-end" style="background:#0F1620 !important; color:#D9AE68 !important;">Actions / Tax Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($payments)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">No payment transactions recorded yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($payments as $p): ?>
                        <tr style="background:#161F2B !important;">
                            <td class="fw-bold text-warning font-monospace" style="background:#161F2B !important;"><?= Security::e($p['payment_reference']) ?></td>
                            <td style="background:#161F2B !important;">
                                <div class="fw-bold text-white"><?= Security::e($p['first_name'] . ' ' . $p['last_name']) ?></div>
                                <div class="font-monospace text-muted small"><?= Security::e($p['email']) ?></div>
                            </td>
                            <td style="background:#161F2B !important; color:#F3EEE2 !important;"><span class="badge bg-secondary font-monospace"><?= Security::e($p['course_title']) ?></span></td>
                            <td style="background:#161F2B !important;"><span class="badge bg-dark border border-secondary font-monospace"><?= strtoupper($p['gateway']) ?></span></td>
                            <td style="background:#161F2B !important;" class="font-monospace text-warning fw-bold">₹ <?= number_format((float)$p['amount'], 2) ?></td>
                            <td style="background:#161F2B !important;"><span class="badge bg-success font-monospace">COMPLETED</span></td>
                            <td style="background:#161F2B !important;" class="small font-monospace text-muted"><?= Format::date($p['payment_date'], 'M d, Y H:i') ?></td>
                            <td class="text-end" style="background:#161F2B !important;">
                                <?php if (!empty($p['invoice'])): ?>
                                    <a href="<?= Url::to('/admin/finance/invoices/' . $p['invoice']['id'] . '/view') ?>" class="btn btn-outline-info btn-sm font-monospace" title="View / Print Statutory 18% GST Invoice">
                                        <i class="bi bi-receipt me-1"></i> View GST Invoice
                                    </a>
                                <?php else: ?>
                                    <form action="<?= Url::to('/admin/finance/payments/' . $p['id'] . '/generate-invoice') ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                        <button type="submit" class="btn btn-outline-warning btn-sm font-monospace" title="Generate Statutory 18% GST Invoice">
                                            <i class="bi bi-file-earmark-plus me-1"></i> Generate Invoice
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Record Payment -->
<div class="modal fade" id="recordPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background:#161F2B; color:#F3EEE2; border:1px solid rgba(243,238,226,0.14);">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-monospace text-warning">Record Student Fee Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= Url::to('/admin/finance/payments') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                    
                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Select Student Admission</label>
                        <select name="admission_id" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);" required>
                            <?php foreach ($admissions as $adm): ?>
                                <option value="<?= $adm['id'] ?>"><?= Security::e($adm['admission_number']) ?> (Fee: ₹<?= number_format((float)$adm['final_fee'], 2) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Amount Paid (₹)</label>
                        <input type="number" step="0.01" name="amount" class="form-control font-monospace" value="3000.00" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Payment Gateway / Method</label>
                        <select name="gateway" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                            <option value="razorpay">Razorpay Online</option>
                            <option value="upi">UPI / GPay / PhonePe</option>
                            <option value="cash">Offline Cash</option>
                            <option value="bank_transfer">Bank Transfer / NEFT</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Transaction ID / Reference Number</label>
                        <input type="text" name="transaction_id" class="form-control font-monospace" placeholder="TXN-9812981">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold btn-sm">Process Payment & Generate 18% GST Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>
