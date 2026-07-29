<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Form Submissions & Lead Inquiries</h2>
        <p class="text-secondary small m-0">Inquiries submitted from public web forms (Ready for Phase 4 CRM Ingestion)</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-inbox"></i> Web Form Inquiries</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Applicant</th>
                            <th>Contact</th>
                            <th>Message</th>
                            <th>Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($submissions)): ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">No form submissions received yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($submissions as $sub): ?>
                                <tr>
                                    <td><span class="badge bg-info font-monospace"><?= Security::e($sub['form_type']) ?></span></td>
                                    <td class="fw-semibold text-light"><?= Security::e($sub['name']) ?></td>
                                    <td class="small">
                                        <div class="text-warning font-monospace"><?= Security::e($sub['email']) ?></div>
                                        <div class="text-muted"><?= Security::e($sub['phone'] ?? '—') ?></div>
                                    </td>
                                    <td class="small text-secondary"><?= Security::e($sub['message'] ?? '—') ?></td>
                                    <td class="small text-muted"><?= Format::date($sub['created_at'], 'M d H:i') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-envelope-check"></i> Newsletter Subscribers</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Email Address</th>
                            <th>Subscribed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($subscribers)): ?>
                            <tr><td colspan="2" class="text-center text-muted py-3">No subscribers.</td></tr>
                        <?php else: ?>
                            <?php foreach ($subscribers as $sub): ?>
                                <tr>
                                    <td class="small font-monospace text-info"><?= Security::e($sub['email']) ?></td>
                                    <td class="small text-muted"><?= Format::date($sub['subscribed_at'], 'M d, Y') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
