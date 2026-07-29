<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">18% GST Tax Invoices Ledger</h2>
        <p class="text-secondary small m-0">Sequential GST Tax Invoices (Subtotal + 9% CGST + 9% SGST = Total Amount)</p>
    </div>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle m-0">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Billed To</th>
                    <th>Payment Reference</th>
                    <th>Subtotal (Base)</th>
                    <th>CGST (9%)</th>
                    <th>SGST (9%)</th>
                    <th>Total Amount</th>
                    <th>Issued Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($invoices)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">No GST invoices generated yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($invoices as $inv): ?>
                        <tr>
                            <td class="fw-bold text-warning font-monospace"><?= Security::e($inv['invoice_number']) ?></td>
                            <td>
                                <div class="fw-semibold text-light"><?= Security::e($inv['first_name'] . ' ' . $inv['last_name']) ?></div>
                                <div class="font-monospace text-info small"><?= Security::e($inv['email']) ?></div>
                            </td>
                            <td class="font-monospace text-muted small"><?= Security::e($inv['payment_reference']) ?></td>
                            <td class="font-monospace text-secondary">₹ <?= number_format((float)$inv['subtotal'], 2) ?></td>
                            <td class="font-monospace text-info">₹ <?= number_format((float)$inv['cgst_amount'], 2) ?></td>
                            <td class="font-monospace text-info">₹ <?= number_format((float)$inv['sgst_amount'], 2) ?></td>
                            <td class="font-monospace text-warning fw-bold">₹ <?= number_format((float)$inv['total_amount'], 2) ?></td>
                            <td class="small font-monospace text-muted"><?= Format::date($inv['issued_at'], 'M d, Y') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
