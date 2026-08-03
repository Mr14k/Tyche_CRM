<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0"><i class="bi bi-credit-card-2-front-fill me-2 text-warning"></i>Merchant Payment Gateways & Settlement</h2>
        <p class="text-secondary small m-0">Configure your academy's dedicated Razorpay, Stripe, or Manual UPI QR credentials. Collected student course fees deposit directly into your business bank account.</p>
    </div>
    <div>
        <span class="badge bg-success font-monospace px-3 py-2"><i class="bi bi-shield-check me-1"></i> 100% Tenant Credential Isolated</span>
    </div>
</div>

<form action="<?= Url::to('/admin/finance/settings') ?>" method="POST">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

    <!-- Gateway Selection & Currency Card -->
    <div class="card-custom p-4 mb-4 border border-warning-subtle">
        <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-sliders me-1"></i> Active Checkout Gateway Configuration</h5>
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label text-warning font-monospace small">Select Active Merchant Gateway</label>
                <select name="payment_active_gateway" class="form-select font-monospace bg-dark text-light border-secondary">
                    <option value="offline" <?= ($config['active_gateway'] ?? 'offline') === 'offline' ? 'selected' : '' ?>>Offline Manual (Direct Bank Transfer & UPI VPA QR)</option>
                    <option value="razorpay" <?= ($config['active_gateway'] ?? '') === 'razorpay' ? 'selected' : '' ?>>Razorpay Merchant Account (Automated UPI, Cards, NetBanking)</option>
                    <option value="stripe" <?= ($config['active_gateway'] ?? '') === 'stripe' ? 'selected' : '' ?>>Stripe Global (International Cards & Apple Pay)</option>
                </select>
                <div class="form-text text-muted small">Select which payment processing method is presented to students during checkout.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-warning font-monospace small">Academy Currency Code</label>
                <input type="text" name="payment_currency" class="form-control font-monospace bg-dark text-light border-secondary" value="<?= Security::e($config['currency'] ?? 'INR') ?>" placeholder="INR / USD / EUR" required>
                <div class="form-text text-muted small">Currency ISO code for tuition fee payments (e.g. INR for ₹ India, USD for $).</div>
            </div>
        </div>
    </div>

    <!-- Razorpay Integration Card -->
    <div class="card-custom p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="h6 font-monospace text-info m-0"><i class="bi bi-lightning-charge-fill me-1"></i> Razorpay Merchant API Credentials</h5>
            <?php if (!empty($config['razorpay']['is_configured'])): ?>
                <span class="badge bg-success font-monospace"><i class="bi bi-check-circle me-1"></i> Configured</span>
            <?php else: ?>
                <span class="badge bg-secondary font-monospace">Not Configured</span>
            <?php endif; ?>
        </div>
        <p class="text-secondary small mb-3">Enter your business's Razorpay Key ID and Key Secret from your Razorpay Dashboard (Settings → API Keys). Funds settle directly to your registered bank account.</p>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-light font-monospace small">Razorpay Key ID</label>
                <input type="text" name="razorpay_key_id" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="rzp_live_XXXXXXXXXXXXXXXX" value="<?= Security::e($config['razorpay']['key_id'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label text-light font-monospace small">Razorpay Key Secret</label>
                <input type="password" name="razorpay_key_secret" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="••••••••••••••••••••••••" value="<?= Security::e($config['razorpay']['key_secret'] ?? '') ?>">
            </div>
        </div>
        <div>
            <label class="form-label text-light font-monospace small">Razorpay Webhook Secret (Optional for Automated Payment Reconciliation)</label>
            <input type="text" name="razorpay_webhook_secret" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="whsec_XXXXXXXXXXXXXXXX" value="<?= Security::e($config['razorpay']['webhook_secret'] ?? '') ?>">
        </div>
    </div>

    <!-- Stripe Integration Card -->
    <div class="card-custom p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="h6 font-monospace text-info m-0"><i class="bi bi-globe me-1"></i> Stripe Merchant API Credentials</h5>
            <?php if (!empty($config['stripe']['is_configured'])): ?>
                <span class="badge bg-success font-monospace"><i class="bi bi-check-circle me-1"></i> Configured</span>
            <?php else: ?>
                <span class="badge bg-secondary font-monospace">Not Configured</span>
            <?php endif; ?>
        </div>
        <p class="text-secondary small mb-3">Enter your Stripe Publishable & Secret Keys from your Stripe Dashboard (Developers → API Keys) for international student billing.</p>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-light font-monospace small">Stripe Publishable Key</label>
                <input type="text" name="stripe_publishable_key" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="pk_live_XXXXXXXXXXXXXXXX" value="<?= Security::e($config['stripe']['publishable_key'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label text-light font-monospace small">Stripe Secret Key</label>
                <input type="password" name="stripe_secret_key" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="sk_live_••••••••••••••••" value="<?= Security::e($config['stripe']['secret_key'] ?? '') ?>">
            </div>
        </div>
        <div>
            <label class="form-label text-light font-monospace small">Stripe Webhook Secret (Optional)</label>
            <input type="text" name="stripe_webhook_secret" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="whsec_XXXXXXXXXXXXXXXX" value="<?= Security::e($config['stripe']['webhook_secret'] ?? '') ?>">
        </div>
    </div>

    <!-- Manual UPI VPA & Bank Transfer Card -->
    <div class="card-custom p-4 mb-4">
        <h5 class="h6 font-monospace text-info mb-3"><i class="bi bi-qr-code-scan me-1"></i> Offline UPI & Direct Bank Transfer Instructions</h5>
        <p class="text-secondary small mb-3">Provide your academy's UPI ID (Google Pay, PhonePe, Paytm, BHIM) and Bank Account details for students paying via manual offline transfers.</p>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-light font-monospace small">Academy Merchant UPI VPA ID</label>
                <input type="text" name="payment_upi_id" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="academyname@okaxis" value="<?= Security::e($config['offline']['upi_id'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label text-light font-monospace small">Bank Account & IFSC Code Details</label>
                <input type="text" name="payment_bank_details" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="Bank: HDFC | A/C: 501000123456 | IFSC: HDFC0001234" value="<?= Security::e($config['offline']['bank_details'] ?? '') ?>">
            </div>
        </div>
        <div>
            <label class="form-label text-light font-monospace small">Manual Payment Verification Instructions for Students</label>
            <textarea name="payment_manual_instructions" class="form-control font-monospace bg-dark text-light border-secondary" rows="3" placeholder="Please upload payment screenshot or UTR/transaction reference number after transferring tuition fees."><?= Security::e($config['offline']['instructions'] ?? '') ?></textarea>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center">
        <a href="<?= Url::to('/admin/finance/payments') ?>" class="btn btn-outline-secondary font-monospace"><i class="bi bi-arrow-left me-1"></i> Back to Payment Transactions</a>
        <button type="submit" class="btn btn-gold px-4 py-2 font-monospace"><i class="bi bi-save me-1"></i> Save Payment Gateway Credentials</button>
    </div>
</form>
