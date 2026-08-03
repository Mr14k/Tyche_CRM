<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Global Academy & Payment Settings</h2>
        <p class="text-secondary small m-0">Configure branding, tenant-specific payment gateways (Razorpay, Stripe, UPI), tracking scripts, and sitemaps</p>
    </div>
</div>

<form action="<?= Url::to('/admin/cms/settings') ?>" method="POST">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

    <!-- Independent Tenant Payment Gateway Card -->
    <div class="card-custom p-4 mb-4 border border-warning-subtle">
        <h5 class="h6 font-monospace text-warning mb-2"><i class="bi bi-credit-card-2-front-fill me-1"></i> Independent Payment Gateway Integration (Tenant Isolated)</h5>
        <p class="text-muted small mb-3">Configure your academy's dedicated Razorpay, Stripe, or UPI merchant accounts. Collected student fees settle directly into your business bank account.</p>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label text-warning font-monospace small">Active Merchant Payment Gateway</label>
                <select name="payment_active_gateway" class="form-select font-monospace">
                    <option value="offline" <?= ($settings['payment_active_gateway'] ?? 'offline') === 'offline' ? 'selected' : '' ?>>Offline Manual (UPI QR & Direct Bank Transfer)</option>
                    <option value="razorpay" <?= ($settings['payment_active_gateway'] ?? '') === 'razorpay' ? 'selected' : '' ?>>Razorpay India (Automated UPI, Cards, NetBanking, EMI)</option>
                    <option value="stripe" <?= ($settings['payment_active_gateway'] ?? '') === 'stripe' ? 'selected' : '' ?>>Stripe Global (International Cards & Apple Pay)</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label text-warning font-monospace small">Base Currency Code</label>
                <input type="text" name="payment_currency" class="form-control font-monospace" value="<?= Security::e($settings['payment_currency'] ?? 'INR') ?>" placeholder="INR / USD / EUR">
            </div>
        </div>

        <!-- Razorpay Credentials Block -->
        <div class="p-3 bg-dark bg-opacity-50 rounded mb-3 border border-secondary">
            <h6 class="text-info font-monospace small mb-2"><i class="bi bi-shield-lock me-1"></i> Razorpay Merchant API Credentials</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-light font-monospace small">Razorpay Key ID</label>
                    <input type="text" name="razorpay_key_id" class="form-control font-monospace" placeholder="rzp_live_XXXXXXXXXXXX" value="<?= Security::e($settings['razorpay_key_id'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-light font-monospace small">Razorpay Key Secret</label>
                    <input type="password" name="razorpay_key_secret" class="form-control font-monospace" placeholder="••••••••••••••••••••" value="<?= Security::e($settings['razorpay_key_secret'] ?? '') ?>">
                </div>
            </div>
        </div>

        <!-- Stripe Credentials Block -->
        <div class="p-3 bg-dark bg-opacity-50 rounded mb-3 border border-secondary">
            <h6 class="text-info font-monospace small mb-2"><i class="bi bi-shield-lock me-1"></i> Stripe Merchant API Credentials</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-light font-monospace small">Stripe Publishable Key</label>
                    <input type="text" name="stripe_publishable_key" class="form-control font-monospace" placeholder="pk_live_XXXXXXXXXXXX" value="<?= Security::e($settings['stripe_publishable_key'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-light font-monospace small">Stripe Secret Key</label>
                    <input type="password" name="stripe_secret_key" class="form-control font-monospace" placeholder="sk_live_••••••••••••••••" value="<?= Security::e($settings['stripe_secret_key'] ?? '') ?>">
                </div>
            </div>
        </div>

        <!-- Offline UPI / Bank Details Block -->
        <div class="p-3 bg-dark bg-opacity-50 rounded border border-secondary">
            <h6 class="text-info font-monospace small mb-2"><i class="bi bi-qr-code-scan me-1"></i> Manual UPI VPA & Bank Transfer Details</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-light font-monospace small">Academy UPI VPA ID</label>
                    <input type="text" name="payment_upi_id" class="form-control font-monospace" placeholder="academyname@okaxis" value="<?= Security::e($settings['payment_upi_id'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-light font-monospace small">Bank Account Number / IFSC</label>
                    <input type="text" name="payment_bank_details" class="form-control font-monospace" placeholder="A/C: 123456789 | IFSC: HDFC0001234" value="<?= Security::e($settings['payment_bank_details'] ?? '') ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- General & Contact Parameters -->
    <div class="card-custom p-4 mb-4">
        <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-building"></i> General & Contact Parameters</h5>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-warning font-monospace small">Academy Site Name</label>
                <input type="text" name="site_name" class="form-control" value="<?= Security::e($settings['site_name'] ?? '') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label text-warning font-monospace small">Contact Email</label>
                <input type="email" name="contact_email" class="form-control" value="<?= Security::e($settings['contact_email'] ?? '') ?>" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-warning font-monospace small">Contact Phone Number</label>
                <input type="text" name="contact_phone" class="form-control" value="<?= Security::e($settings['contact_phone'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label text-warning font-monospace small">Physical Address</label>
                <input type="text" name="address" class="form-control" value="<?= Security::e($settings['address'] ?? '') ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-warning font-monospace small">Footer Copyright Text</label>
            <input type="text" name="footer_copyright" class="form-control" value="<?= Security::e($settings['footer_copyright'] ?? '') ?>">
        </div>
    </div>

    <!-- Analytics & Tracking -->
    <div class="card-custom p-4 mb-4">
        <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-code-slash"></i> Analytics, Pixel & Script Injection</h5>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label text-warning font-monospace small">Google Analytics ID</label>
                <input type="text" name="google_analytics_id" class="form-control font-monospace" placeholder="G-XXXXXXXXXX" value="<?= Security::e($settings['google_analytics_id'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label text-warning font-monospace small">Google Tag Manager ID</label>
                <input type="text" name="google_tag_manager_id" class="form-control font-monospace" placeholder="GTM-XXXXXXX" value="<?= Security::e($settings['google_tag_manager_id'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label text-warning font-monospace small">Meta Pixel ID</label>
                <input type="text" name="meta_pixel_id" class="form-control font-monospace" placeholder="1234567890" value="<?= Security::e($settings['meta_pixel_id'] ?? '') ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-warning font-monospace small">Custom Header Scripts (Raw HTML/JS)</label>
            <textarea name="custom_header_scripts" class="form-control font-monospace" rows="3" placeholder="<!-- Header Scripts -->"><?= Security::e($settings['custom_header_scripts'] ?? '') ?></textarea>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a href="<?= Url::to('/sitemap.xml') ?>" target="_blank" class="btn btn-outline-info font-monospace btn-sm"><i class="bi bi-diagram-3"></i> View XML Sitemap</a>
        <button type="submit" class="btn btn-gold px-4 py-2 font-monospace"><i class="bi bi-save"></i> Save Global Settings</button>
    </div>
</form>
