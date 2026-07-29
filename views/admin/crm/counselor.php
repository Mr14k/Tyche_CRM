<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Counselor Sales Desk & Demos</h2>
        <p class="text-secondary small m-0">Log follow-up calls, schedule demo classes, and track counselor activities</p>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Follow-up Call Logs -->
    <div class="col-md-7">
        <div class="card-custom p-4 mb-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-telephone-outbound me-1"></i> Recent Follow-up Call Logs</h5>
            <div class="table-responsive">
                <table class="table table-custom align-middle m-0" style="background:#161F2B !important; color:#F3EEE2 !important;">
                    <thead>
                        <tr>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Prospect Lead</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Channel</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Call Notes</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Log Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($followups)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No follow-ups logged yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($followups as $f): ?>
                                <tr style="background:#161F2B !important;">
                                    <td style="background:#161F2B !important;">
                                        <div class="fw-semibold text-light"><?= Security::e($f['first_name'] . ' ' . ($f['last_name'] ?? '')) ?></div>
                                        <div class="font-monospace text-info small"><?= Security::e($f['phone']) ?> (<?= Security::e($f['lead_code']) ?>)</div>
                                    </td>
                                    <td style="background:#161F2B !important;"><span class="badge bg-info font-monospace text-dark"><?= strtoupper($f['type']) ?></span></td>
                                    <td style="background:#161F2B !important;" class="small text-secondary"><?= Security::e($f['notes']) ?></td>
                                    <td style="background:#161F2B !important;" class="small font-monospace text-muted"><?= Format::date($f['created_at'], 'M d H:i') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Log Follow-up Form -->
    <div class="col-md-5">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-telephone-plus me-1"></i> Log Follow-up Activity</h5>
            <form action="<?= Url::to('/admin/crm/counselor/followup') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="mb-3">
                    <label class="form-label text-warning small font-monospace">Select Prospect Lead *</label>
                    <select name="lead_id" class="form-select font-monospace" required style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="">-- Choose Lead from Pipeline --</option>
                        <?php if (!empty($leads)): ?>
                            <?php foreach ($leads as $l): ?>
                                <option value="<?= $l['id'] ?>">
                                    <?= Security::e($l['first_name'] . ' ' . $l['last_name']) ?> (<?= Security::e($l['lead_code']) ?>) - <?= Security::e($l['phone']) ?> [<?= strtoupper($l['status']) ?>]
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small font-monospace">Follow-up Channel</label>
                    <select name="type" class="form-select font-monospace" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="call">Phone Call (Click-to-Call)</option>
                        <option value="whatsapp">WhatsApp Message</option>
                        <option value="email">Email Outreach</option>
                        <option value="meeting">In-Person / Zoom Meeting</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small font-monospace">Call Notes & Customer Remarks *</label>
                    <textarea name="notes" class="form-control font-monospace small" rows="3" placeholder="Customer interested in weekend batch, requested fee breakdown..." required></textarea>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4 font-monospace fw-bold w-100 py-2">
                    <i class="bi bi-check-circle-fill me-1"></i> Log Follow-up & Update Timeline
                </button>
            </form>
        </div>
    </div>
</div>
