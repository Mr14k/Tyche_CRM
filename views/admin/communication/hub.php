<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Communication & Notification Hub</h2>
        <p class="text-secondary small m-0">Dispatch multi-channel alerts over Email SMTP, SMS, WhatsApp API, and In-App Notifications</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-clock-history"></i> Communication Dispatch History</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Recipient</th>
                            <th>Channel</th>
                            <th>Subject / Message</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($logs)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No communication logs recorded.</td></tr>
                        <?php else: ?>
                            <?php foreach ($logs as $lg): ?>
                                <tr>
                                    <td class="fw-semibold text-light small"><?= Security::e($lg['recipient']) ?></td>
                                    <td><span class="badge bg-info font-monospace"><?= strtoupper($lg['channel']) ?></span></td>
                                    <td>
                                        <div class="fw-semibold text-light small"><?= Security::e($lg['subject'] ?? 'Notification') ?></div>
                                        <div class="text-secondary small text-truncate" style="max-width:260px;"><?= Security::e($lg['message_body']) ?></div>
                                    </td>
                                    <td><span class="badge bg-success font-monospace">SENT</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-broadcast"></i> Dispatch Broadcast Notification</h5>
            <form action="<?= Url::to('/admin/communication/broadcast') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Channel</label>
                    <select name="channel" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="email">Email SMTP</option>
                        <option value="sms">SMS Gateway</option>
                        <option value="whatsapp">WhatsApp Template API</option>
                        <option value="in_app">In-App Notification</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Subject / Title</label>
                    <input type="text" name="subject" class="form-control" placeholder="e.g. Special Live Workshop Announcement" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Message Body</label>
                    <textarea name="message" class="form-control font-monospace" rows="4" placeholder="Dear Students, Join us for..." required></textarea>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4 font-monospace"><i class="bi bi-send-fill"></i> Dispatch Multi-Channel Broadcast</button>
            </form>
        </div>
    </div>
</div>
