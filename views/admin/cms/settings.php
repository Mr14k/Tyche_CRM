<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Global Website Settings</h2>
        <p class="text-secondary small m-0">Configure branding, contact details, tracking scripts, and sitemaps</p>
    </div>
</div>

<form action="<?= Url::to('/admin/cms/settings') ?>" method="POST">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

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
