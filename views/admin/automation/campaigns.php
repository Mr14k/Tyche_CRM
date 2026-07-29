<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Marketing Automation & Referral Engine</h2>
        <p class="text-secondary small m-0">Automate lead drip campaigns, course promotions, and student referral codes</p>
    </div>
    <button class="btn btn-gold btn-sm px-3" data-bs-toggle="modal" data-bs-target="#createCampaignModal">
        <i class="bi bi-megaphone-fill me-1"></i> Create Drip Campaign
    </button>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-broadcast"></i> Active Automated Campaigns</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Campaign Title</th>
                            <th>Channel</th>
                            <th>Target Segment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($campaigns as $cmp): ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold text-light"><?= Security::e($cmp['title']) ?></div>
                                    <div class="font-monospace text-info small"><?= Security::e($cmp['subject'] ?? 'Notification') ?></div>
                                </td>
                                <td><span class="badge bg-info font-monospace"><?= strtoupper($cmp['channel']) ?></span></td>
                                <td class="small text-secondary"><?= Security::e($cmp['target_segment']) ?></td>
                                <td><span class="badge bg-success font-monospace"><?= strtoupper($cmp['status']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-people-fill"></i> Student Referral Engine Logs</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Referred Contact</th>
                            <th>Status</th>
                            <th>Reward</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($referrals)): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">No referral codes redeemed yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($referrals as $ref): ?>
                                <tr>
                                    <td class="small text-light font-monospace"><?= Security::e($ref['referred_email']) ?></td>
                                    <td><span class="badge bg-warning text-dark font-monospace"><?= strtoupper($ref['status']) ?></span></td>
                                    <td class="font-monospace text-success fw-bold">₹ <?= number_format((float)$ref['reward_amount'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Campaign -->
<div class="modal fade" id="createCampaignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background:#161F2B; color:#F3EEE2; border:1px solid rgba(243,238,226,0.14);">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-monospace text-warning">Create Automated Marketing Campaign</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= Url::to('/admin/automation/campaigns') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                    
                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Campaign Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Masterclass Drip Nurture Series" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Communication Channel</label>
                        <select name="channel" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                            <option value="email">Email Campaign</option>
                            <option value="whatsapp">WhatsApp Drip</option>
                            <option value="sms">SMS Flash Promo</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Subject / Title</label>
                        <input type="text" name="subject" class="form-control" placeholder="e.g. Exclusive Early Bird Scholarship Inside">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Content Template</label>
                        <textarea name="template" class="form-control font-monospace" rows="3" placeholder="Dear {{lead_name}}..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold btn-sm">Schedule Campaign</button>
                </div>
            </form>
        </div>
    </div>
</div>
