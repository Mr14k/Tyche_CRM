<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Discount Coupons & Scholarship Codes</h2>
        <p class="text-secondary small m-0">Create percentage/flat discount codes with 30-day default expiry and usage caps</p>
    </div>
    <button class="btn btn-gold btn-sm px-3" data-bs-toggle="modal" data-bs-target="#createCouponModal">
        <i class="bi bi-ticket-perforated-fill me-1"></i> Create Discount Coupon
    </button>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle m-0">
            <thead>
                <tr>
                    <th>Coupon Code</th>
                    <th>Discount Structure</th>
                    <th>Usage Limit</th>
                    <th>Expires On</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($coupons as $cp): ?>
                    <tr>
                        <td class="fw-bold text-warning font-monospace"><?= Security::e($cp['code']) ?></td>
                        <td>
                            <?php if ($cp['discount_type'] === 'percentage'): ?>
                                <span class="badge bg-success font-monospace"><?= (float)$cp['discount_value'] ?>% OFF</span>
                            <?php else: ?>
                                <span class="badge bg-info font-monospace">₹ <?= number_format((float)$cp['discount_value'], 2) ?> OFF</span>
                            <?php endif; ?>
                        </td>
                        <td class="font-monospace text-light"><?= $cp['used_count'] ?> / <?= $cp['max_uses'] ?> Redemptions</td>
                        <td class="small font-monospace text-secondary"><?= Format::date($cp['expires_at'], 'M d, Y') ?></td>
                        <td><span class="badge bg-success font-monospace">ACTIVE</span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Create Coupon -->
<div class="modal fade" id="createCouponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background:#161F2B; color:#F3EEE2; border:1px solid rgba(243,238,226,0.14);">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-monospace text-warning">Create Discount Coupon</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= Url::to('/admin/automation/coupons') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                    
                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Coupon Code</label>
                        <input type="text" name="code" class="form-control font-monospace" placeholder="e.g. TYCHE2026" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label text-warning font-monospace small">Discount Type</label>
                            <select name="discount_type" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                                <option value="percentage">Percentage (%)</option>
                                <option value="flat">Flat Amount (₹)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-warning font-monospace small">Value</label>
                            <input type="number" step="0.01" name="discount_value" class="form-control font-monospace" placeholder="15" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Max Usage Limit</label>
                        <input type="number" name="max_uses" class="form-control font-monospace" value="100" required>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold btn-sm">Create Coupon (30-Day Expiry)</button>
                </div>
            </form>
        </div>
    </div>
</div>
