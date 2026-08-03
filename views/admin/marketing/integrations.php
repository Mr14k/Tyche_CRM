<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0"><i class="bi bi-plugin text-warning me-2"></i>Meta Ads & Google Ads Direct Lead Ingestion</h2>
        <p class="text-secondary small m-0">Connect your Facebook/Instagram Lead Ads & Google Lead Form Extensions for zero-latency, tenant-isolated CRM lead capture.</p>
    </div>
    <div>
        <span class="badge bg-success font-monospace px-3 py-2"><i class="bi bi-shield-lock-fill me-1"></i> AES-256 Encrypted Tokens</span>
    </div>
</div>

<!-- Webhook Integration Technical Credentials Header -->
<div class="card-custom p-4 mb-4 border border-warning-subtle">
    <h5 class="h6 font-monospace text-warning mb-2"><i class="bi bi-broadcast me-1"></i> Webhook Endpoint URLs for Ad Platforms</h5>
    <p class="text-muted small mb-3">Copy and paste these webhook URLs into your Meta Developer App Dashboard and Google Ads Lead Form Extension settings.</p>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label text-light font-monospace small">Meta Webhook Callback URL</label>
            <div class="input-group">
                <input type="text" class="form-control font-monospace bg-dark text-info border-secondary" value="<?= Security::e($metaWebhookUrl) ?>" readonly>
                <button class="btn btn-outline-secondary font-monospace" type="button" onclick="navigator.clipboard.writeText('<?= Security::e($metaWebhookUrl) ?>')">Copy</button>
            </div>
            <div class="form-text text-muted small">Meta Verify Token: <code class="text-warning">TycheMetaVerifyToken2026</code></div>
        </div>
        <div class="col-md-6">
            <label class="form-label text-light font-monospace small">Google Ads Webhook Endpoint</label>
            <div class="input-group">
                <input type="text" class="form-control font-monospace bg-dark text-info border-secondary" value="<?= Security::e($googleWebhookUrl) ?>" readonly>
                <button class="btn btn-outline-secondary font-monospace" type="button" onclick="navigator.clipboard.writeText('<?= Security::e($googleWebhookUrl) ?>')">Copy</button>
            </div>
            <div class="form-text text-muted small">Payload format: JSON | Real-time Webhook</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Meta (Facebook/Instagram) Lead Ads Card -->
    <div class="col-lg-6">
        <div class="card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="h6 font-monospace text-light m-0"><i class="bi bi-facebook text-primary me-2"></i>Meta Lead Ads Integration</h5>
                <?php if (!empty($metaConnections)): ?>
                    <span class="badge bg-success font-monospace"><i class="bi bi-check-circle me-1"></i> Active (<?= count($metaConnections) ?> Page Connected)</span>
                <?php else: ?>
                    <span class="badge bg-secondary font-monospace">Disconnected</span>
                <?php endif; ?>
            </div>
            <p class="text-secondary small mb-4">Automatically capture leads submitted via Facebook & Instagram Instant Forms directly into your CRM funnel ("New" stage, source = <code class="text-warning">meta_ads</code>).</p>

            <form action="<?= Url::to('/admin/marketing/integrations/meta') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Facebook Page ID</label>
                    <input type="text" name="page_id" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="e.g. 109876543210123" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-warning font-monospace small">Page Access Token (Long-Lived)</label>
                    <input type="password" name="access_token" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="EAAXXXXXXX..." required>
                    <div class="form-text text-muted small">Generated via Meta Business Manager / Developer Portal with <code class="text-info">leads_retrieval</code> permission.</div>
                </div>

                <button type="submit" class="btn btn-primary font-monospace w-100"><i class="bi bi-link-45deg me-1"></i> Connect Meta Lead Ads</button>
            </form>

            <?php if (!empty($metaConnections)): ?>
                <div class="mt-4 pt-3 border-top border-secondary">
                    <h6 class="text-warning font-monospace small mb-2">Connected Meta Pages</h6>
                    <?php foreach ($metaConnections as $mc): ?>
                        <div class="d-flex justify-content-between align-items-center bg-dark p-2 rounded mb-2 border border-secondary">
                            <span class="font-monospace small text-light"><i class="bi bi-file-earmark-text text-primary me-1"></i> Page ID: <?= Security::e($mc['page_or_account_id']) ?></span>
                            <span class="badge bg-success font-monospace">Syncing</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Google Ads Lead Form Extensions Card -->
    <div class="col-lg-6">
        <div class="card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="h6 font-monospace text-light m-0"><i class="bi bi-google text-danger me-2"></i>Google Ads Lead Form Extensions</h5>
                <?php if (!empty($googleConnections)): ?>
                    <span class="badge bg-success font-monospace"><i class="bi bi-check-circle me-1"></i> Active (<?= count($googleConnections) ?> Account Connected)</span>
                <?php else: ?>
                    <span class="badge bg-secondary font-monospace">Disconnected</span>
                <?php endif; ?>
            </div>
            <p class="text-secondary small mb-4">Connect Google Ads Search & Display Lead Form Extensions to ingest Google leads in real time (source = <code class="text-warning">google_ads</code>).</p>

            <form action="<?= Url::to('/admin/marketing/integrations/google') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Google Ads Customer Account ID</label>
                    <input type="text" name="account_id" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="e.g. 123-456-7890" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-warning font-monospace small">Google Webhook Shared Secret / Verification Key</label>
                    <input type="password" name="webhook_key" class="form-control font-monospace bg-dark text-light border-secondary" placeholder="Secret Key configured in Google Lead Form asset" required>
                </div>

                <button type="submit" class="btn btn-danger font-monospace w-100"><i class="bi bi-link-45deg me-1"></i> Connect Google Ads</button>
            </form>

            <?php if (!empty($googleConnections)): ?>
                <div class="mt-4 pt-3 border-top border-secondary">
                    <h6 class="text-warning font-monospace small mb-2">Connected Google Accounts</h6>
                    <?php foreach ($googleConnections as $gc): ?>
                        <div class="d-flex justify-content-between align-items-center bg-dark p-2 rounded mb-2 border border-secondary">
                            <span class="font-monospace small text-light"><i class="bi bi-search text-danger me-1"></i> Customer ID: <?= Security::e($gc['page_or_account_id']) ?></span>
                            <span class="badge bg-success font-monospace">Syncing</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
