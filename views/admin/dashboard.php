<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Platform Executive Overview</h2>
        <p class="text-secondary small m-0">Tyche Monolith Control Center & Live Enrollment Telemetry</p>
    </div>
    <div>
        <span class="badge bg-success px-3 py-2 font-monospace"><i class="bi bi-shield-check me-1"></i> Core PHP 8.2 • System Healthy (<?= $metrics['business_health_score'] ?>%)</span>
    </div>
</div>

<!-- BI TELEMETRY STAT CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-4 border-start border-warning border-4">
            <div class="text-muted small text-uppercase font-monospace">Total Platform Revenue</div>
            <div class="display-6 font-monospace text-warning mt-2">₹ <?= number_format($metrics['total_revenue'], 2) ?></div>
            <div class="text-secondary small mt-1"><i class="bi bi-currency-rupee"></i> 18% GST Compliant</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 border-start border-primary border-4">
            <div class="text-muted small text-uppercase font-monospace">Enrolled Students</div>
            <div class="display-6 font-monospace text-primary mt-2"><?= $metrics['total_students'] ?></div>
            <div class="text-secondary small mt-1"><i class="bi bi-mortarboard-fill"></i> Active Accounts</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 border-start border-info border-4">
            <div class="text-muted small text-uppercase font-monospace">Lead Conversion Rate</div>
            <div class="display-6 font-monospace text-info mt-2"><?= $metrics['conversion_rate'] ?>%</div>
            <div class="text-secondary small mt-1"><i class="bi bi-funnel-fill"></i> CRM Pipeline</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 border-start border-success border-4">
            <div class="text-muted small text-uppercase font-monospace">Verified Certificates</div>
            <div class="display-6 font-monospace text-success mt-2"><?= $metrics['total_certificates'] ?></div>
            <div class="text-secondary small mt-1"><i class="bi bi-qr-code"></i> SHA-256 Validated</div>
        </div>
    </div>
</div>

<!-- LIVE RECENT STUDENT PAYMENTS TABLE -->
<div class="card-custom p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="h6 font-monospace text-warning m-0"><i class="bi bi-credit-card-2-front-fill me-2"></i> Recent Student Payments & Direct Enrollments</h5>
        <a href="<?= Url::to('/admin/finance/payments') ?>" class="btn btn-outline-warning btn-sm font-monospace">View All Payments →</a>
    </div>
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle m-0" style="background:#161F2B !important; color:#F3EEE2 !important;">
            <thead>
                <tr>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Txn Ref</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Student Name & Email</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Course Enrolled</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Amount</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Gateway</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Status</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentPayments)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-3">No payments recorded yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($recentPayments as $p): ?>
                        <tr style="background:#161F2B !important;">
                            <td class="font-monospace text-warning small" style="background:#161F2B !important;"><?= Security::e($p['payment_reference']) ?></td>
                            <td style="background:#161F2B !important;">
                                <div class="fw-bold text-white"><?= Security::e($p['first_name'] . ' ' . $p['last_name']) ?></div>
                                <div class="text-muted small font-monospace"><?= Security::e($p['email']) ?></div>
                            </td>
                            <td style="background:#161F2B !important; color:#F3EEE2 !important;"><span class="badge bg-secondary font-monospace"><?= Security::e($p['course_title']) ?></span></td>
                            <td style="background:#161F2B !important;" class="font-monospace text-warning fw-bold">₹ <?= number_format((float)$p['amount'], 2) ?></td>
                            <td style="background:#161F2B !important;"><span class="badge bg-dark border border-secondary font-monospace"><?= strtoupper(Security::e($p['gateway'])) ?></span></td>
                            <td style="background:#161F2B !important;">
                                <?php if ($p['status'] === 'completed'): ?>
                                    <span class="badge bg-success">Completed</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark"><?= ucfirst(Security::e($p['status'])) ?></span>
                                <?php endif; ?>
                            </td>
                            <td style="background:#161F2B !important;" class="text-muted small font-monospace"><?= Format::date($p['payment_date'], 'd M Y, H:i') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-activity"></i> Recent Activity Audit Stream</h5>
            <div class="table-responsive">
                <table class="table table-custom align-middle m-0" style="background:#161F2B !important; color:#F3EEE2 !important;">
                    <thead>
                        <tr>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Module</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Action</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Description</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentActivities)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">No activity logs recorded yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentActivities as $act): ?>
                                <tr style="background:#161F2B !important;">
                                    <td style="background:#161F2B !important;"><span class="badge bg-secondary font-monospace"><?= Security::e($act['module']) ?></span></td>
                                    <td style="background:#161F2B !important;" class="font-monospace text-info"><?= Security::e($act['action']) ?></td>
                                    <td style="background:#161F2B !important;" class="small text-light"><?= Security::e($act['description']) ?></td>
                                    <td style="background:#161F2B !important;" class="text-muted small"><?= Format::date($act['created_at'], 'H:i:s') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-shield-lock"></i> Authentication & Security Log</h5>
            <div class="table-responsive">
                <table class="table table-custom align-middle m-0" style="background:#161F2B !important; color:#F3EEE2 !important;">
                    <thead>
                        <tr>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Email Attempted</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Status</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">IP Address</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentLogins)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">No authentication attempts recorded.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentLogins as $log): ?>
                                <tr style="background:#161F2B !important;">
                                    <td style="background:#161F2B !important;" class="small font-monospace text-light"><?= Security::e($log['email_attempted']) ?></td>
                                    <td style="background:#161F2B !important;">
                                        <?php if ($log['status'] === 'success'): ?>
                                            <span class="badge bg-success">Success</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?= Security::e($log['status']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="background:#161F2B !important;" class="small font-monospace text-muted"><?= Security::e($log['ip_address']) ?></td>
                                    <td style="background:#161F2B !important;" class="text-muted small"><?= Format::date($log['created_at'], 'H:i:s') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
