<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Leads Sales Pipeline & Lifecycle Management</h2>
        <p class="text-secondary small m-0">Capture, dedupe, SLA tracking, multi-channel outreach, and payment link generation</p>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-info btn-sm font-monospace" data-bs-toggle="modal" data-bs-target="#csvImportModal">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Bulk CSV Import
        </button>
        <button type="button" class="btn btn-gold btn-sm px-3 font-monospace" data-bs-toggle="modal" data-bs-target="#newLeadModal">
            <i class="bi bi-plus-circle me-1"></i> Add New Lead
        </button>
    </div>
</div>

<!-- Executive Telemetry Banner -->
<div class="row g-3 mb-4">
    <div class="col-md-2 col-6">
        <div class="card-custom p-3 text-center">
            <div class="text-secondary small font-monospace">TOTAL LEADS</div>
            <div class="fs-4 fw-bold text-white font-monospace my-1"><?= number_format($telemetry['total_leads']) ?></div>
            <div class="text-success small"><i class="bi bi-graph-up"></i> In System</div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="card-custom p-3 text-center">
            <div class="text-secondary small font-monospace">NEW / SLA DUE</div>
            <div class="fs-4 fw-bold text-warning font-monospace my-1"><?= number_format($telemetry['new_leads']) ?></div>
            <div class="text-danger small font-monospace"><?= number_format($telemetry['sla_breaches']) ?> SLA Breached</div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="card-custom p-3 text-center">
            <div class="text-secondary small font-monospace">CONTACTED %</div>
            <div class="fs-4 fw-bold text-info font-monospace my-1"><?= $telemetry['contacted_pct'] ?>%</div>
            <div class="text-secondary small"><?= number_format($telemetry['contacted_leads']) ?> Contacted</div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="card-custom p-3 text-center">
            <div class="text-secondary small font-monospace">CONVERTED</div>
            <div class="fs-4 fw-bold text-success font-monospace my-1"><?= number_format($telemetry['enrolled_leads']) ?></div>
            <div class="text-success small font-monospace"><?= $telemetry['conversion_pct'] ?>% Conversion</div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="card-custom p-3 text-center">
            <div class="text-secondary small font-monospace">PENDING LINKS</div>
            <div class="fs-4 fw-bold text-warning font-monospace my-1">₹ <?= number_format($telemetry['pending_payments']) ?></div>
            <div class="text-secondary small font-monospace">Active Payment Links</div>
        </div>
    </div>
    <div class="col-md-2 col-6">
        <div class="card-custom p-3 text-center">
            <div class="text-secondary small font-monospace">REVENUE PAID</div>
            <div class="fs-4 fw-bold text-gold font-monospace my-1">₹ <?= number_format($telemetry['revenue_collected']) ?></div>
            <div class="text-success small font-monospace">Statutory 18% GST</div>
        </div>
    </div>
</div>

<!-- Interactive Multi-Filter Control Bar -->
<div class="card-custom p-3 mb-4 border border-warning-subtle">
    <form action="<?= Url::to('/admin/crm/leads') ?>" method="GET" class="row g-2 align-items-center">
        <!-- Preserve active stage status if selected -->
        <?php if (!empty($filters['status'])): ?>
            <input type="hidden" name="status" value="<?= Security::e($filters['status']) ?>">
        <?php endif; ?>

        <div class="col-md-3">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-dark text-warning border-secondary"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control form-control-sm bg-dark text-light border-secondary font-monospace" placeholder="Search name, phone, email, code..." value="<?= Security::e($filters['search'] ?? '') ?>">
            </div>
        </div>

        <div class="col-md-2">
            <select name="counselor_id" class="form-select form-select-sm bg-dark text-light border-secondary font-monospace" onchange="this.form.submit()">
                <option value="">-- Filter Counselor --</option>
                <?php foreach ($counselors as $cn): ?>
                    <option value="<?= $cn['id'] ?>" <?= ((string)($filters['counselor_id'] ?? '') === (string)$cn['id']) ? 'selected' : '' ?>>
                        <?= Security::e($cn['first_name'] . ' ' . $cn['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <select name="course_id" class="form-select form-select-sm bg-dark text-light border-secondary font-monospace" onchange="this.form.submit()">
                <option value="">-- Filter Course --</option>
                <?php foreach ($courses as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ((string)($filters['course_id'] ?? '') === (string)$c['id']) ? 'selected' : '' ?>>
                        <?= Security::e($c['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <select name="source" class="form-select form-select-sm bg-dark text-light border-secondary font-monospace" onchange="this.form.submit()">
                <option value="">-- Filter Source --</option>
                <option value="website_form" <?= ($filters['source'] ?? '') === 'website_form' ? 'selected' : '' ?>>Website Form</option>
                <option value="google_ads" <?= ($filters['source'] ?? '') === 'google_ads' ? 'selected' : '' ?>>Google Ads</option>
                <option value="meta_ads" <?= ($filters['source'] ?? '') === 'meta_ads' ? 'selected' : '' ?>>Meta Advantage+</option>
                <option value="whatsapp" <?= ($filters['source'] ?? '') === 'whatsapp' ? 'selected' : '' ?>>WhatsApp Cloud API</option>
                <option value="walk_in" <?= ($filters['source'] ?? '') === 'walk_in' ? 'selected' : '' ?>>Walk-in / Front Desk</option>
                <option value="referral" <?= ($filters['source'] ?? '') === 'referral' ? 'selected' : '' ?>>Student Referral</option>
                <option value="inbound_call" <?= ($filters['source'] ?? '') === 'inbound_call' ? 'selected' : '' ?>>Inbound Call</option>
                <option value="manual" <?= ($filters['source'] ?? '') === 'manual' ? 'selected' : '' ?>>Manual Entry</option>
            </select>
        </div>

        <div class="col-md-2">
            <div class="form-check form-switch m-0 pt-1">
                <input class="form-check-input" type="checkbox" name="is_sla_breached" value="1" id="slaFilter" <?= !empty($filters['is_sla_breached']) ? 'checked' : '' ?> onchange="this.form.submit()">
                <label class="form-check-label font-monospace text-danger small" for="slaFilter">SLA Breached Only</label>
            </div>
        </div>

        <div class="col-md-1 text-end">
            <a href="<?= Url::to('/admin/crm/leads') ?>" class="btn btn-outline-secondary btn-sm font-monospace w-100" title="Reset All Filters"><i class="bi bi-x-circle"></i> Reset</a>
        </div>
    </form>
</div>

<!-- Stage Funnel Tabs -->
<div class="d-flex gap-2 overflow-x-auto pb-2 mb-4">
    <a href="<?= Url::to('/admin/crm/leads') ?>" class="btn btn-sm font-monospace <?= empty($filters['status']) ? 'btn-gold' : 'btn-outline-secondary text-light' ?>">
        ALL (<?= number_format($telemetry['total_leads']) ?>)
    </a>
    <?php 
    $stageBadges = [
        'new' => ['label' => 'New Lead', 'class' => 'btn-outline-warning'],
        'contacted' => ['label' => 'Contacted', 'class' => 'btn-outline-info'],
        'qualified' => ['label' => 'Qualified', 'class' => 'btn-outline-primary'],
        'nurturing' => ['label' => 'Nurturing', 'class' => 'btn-outline-secondary'],
        'application_sent' => ['label' => 'Application Sent', 'class' => 'btn-outline-light'],
        'payment_link_generated' => ['label' => 'Payment Link', 'class' => 'btn-outline-warning'],
        'enrolled' => ['label' => 'Enrolled', 'class' => 'btn-outline-success'],
        'lost' => ['label' => 'Lost / Dropped', 'class' => 'btn-outline-danger']
    ];
    foreach ($stageBadges as $st => $info):
        $count = $telemetry['stages'][$st] ?? 0;
        $active = ($filters['status'] ?? '') === $st;
    ?>
        <a href="<?= Url::to('/admin/crm/leads?status=' . $st) ?>" class="btn btn-sm font-monospace <?= $active ? 'btn-gold' : $info['class'] ?>">
            <?= strtoupper($info['label']) ?> (<?= number_format($count) ?>)
        </a>
    <?php endforeach; ?>
</div>

<!-- Lead Pipeline Table -->
<div class="card-custom p-4 mb-4">
    <div class="table-responsive">
        <table class="table table-custom align-middle m-0" style="background:#161F2B !important; color:#F3EEE2 !important;">
            <thead>
                <tr>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Lead Code & Name</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Contact Details</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Course Target</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Source</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Score</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Stage</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Assigned Counselor</th>
                    <th class="text-end" style="background:#0F1620 !important; color:#D9AE68 !important;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($leads)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">No leads found matching your active pipeline filters.</td></tr>
                <?php else: ?>
                    <?php foreach ($leads as $l): ?>
                        <tr style="background:#161F2B !important;">
                            <td style="background:#161F2B !important;">
                                <div class="fw-bold font-monospace text-gold"><?= Security::e($l['lead_code']) ?></div>
                                <div class="fw-bold text-white fs-6"><?= Security::e($l['first_name'] . ' ' . $l['last_name']) ?></div>
                                <?php if (!empty($l['is_sla_breached'])): ?>
                                    <span class="badge bg-danger font-monospace"><i class="bi bi-alarm-fill me-1"></i> SLA BREACH</span>
                                <?php endif; ?>
                            </td>
                            <td style="background:#161F2B !important;" class="font-monospace small">
                                <div><i class="bi bi-telephone text-warning me-1"></i> <?= Security::e($l['phone']) ?></div>
                                <div class="text-secondary"><i class="bi bi-envelope text-info me-1"></i> <?= Security::e($l['email']) ?></div>
                            </td>
                            <td style="background:#161F2B !important;">
                                <div class="small fw-bold text-light"><?= Security::e($l['course_title'] ?? 'Digital Marketing Executive') ?></div>
                                <?php if (!empty($l['batch_name'])): ?>
                                    <div class="small font-monospace text-muted"><?= Security::e($l['batch_name']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td style="background:#161F2B !important;">
                                <span class="badge bg-secondary font-monospace"><?= strtoupper(str_replace('_', ' ', $l['source'])) ?></span>
                            </td>
                            <td style="background:#161F2B !important;">
                                <div class="progress" style="height: 6px; width: 60px; background: #0F1620;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?= (int)$l['lead_score'] ?>%;"></div>
                                </div>
                                <div class="small font-monospace text-warning mt-1"><?= (int)$l['lead_score'] ?> / 100</div>
                            </td>
                            <td style="background:#161F2B !important;">
                                <?php
                                $statusBadge = match($l['status']) {
                                    'new' => 'bg-warning text-dark',
                                    'contacted' => 'bg-info text-dark',
                                    'qualified' => 'bg-primary text-white',
                                    'nurturing' => 'bg-secondary text-white',
                                    'application_sent' => 'bg-light text-dark',
                                    'payment_link_generated' => 'bg-warning text-dark',
                                    'enrolled' => 'bg-success text-white',
                                    'lost' => 'bg-danger text-white',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <span class="badge <?= $statusBadge ?> font-monospace"><?= strtoupper(str_replace('_', ' ', $l['status'])) ?></span>
                                <?php if ($l['status'] === 'lost' && !empty($l['lost_reason'])): ?>
                                    <div class="small text-danger font-monospace mt-1"><?= strtoupper(str_replace('_', ' ', $l['lost_reason'])) ?></div>
                                <?php endif; ?>
                            </td>
                            <!-- Inline Quick Counselor Assign Dropdown -->
                            <td style="background:#161F2B !important;" class="small font-monospace">
                                <form action="<?= Url::to('/admin/crm/leads/' . $l['id'] . '/assign-counselor') ?>" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                    <input type="hidden" name="redirect_back" value="<?= Security::e($_SERVER['REQUEST_URI']) ?>">
                                    <select name="counselor_id" class="form-select form-select-sm bg-dark text-warning border-secondary font-monospace py-0 px-2" style="font-size: 0.78rem;" onchange="this.form.submit()">
                                        <option value="">-- Unassigned --</option>
                                        <?php foreach ($counselors as $cn): ?>
                                            <option value="<?= $cn['id'] ?>" <?= ((int)($l['counselor_id'] ?? 0) === (int)$cn['id']) ? 'selected' : '' ?>>
                                                <?= Security::e($cn['first_name'] . ' ' . $cn['last_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </td>
                            <td class="text-end" style="background:#161F2B !important;">
                                <a href="<?= Url::to('/admin/crm/leads/' . $l['id']) ?>" class="btn btn-gold btn-sm px-3 font-monospace">
                                    <i class="bi bi-eye-fill me-1"></i> Lead 360° View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Lead -->
<div class="modal fade" id="newLeadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-elevated text-light border">
            <div class="modal-header border-bottom border-line">
                <h5 class="modal-title font-monospace text-gold"><i class="bi bi-person-plus me-1"></i> Add New Lead to Pipeline</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= Url::to('/admin/crm/leads') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label text-warning small font-monospace">First Name *</label>
                            <input type="text" name="first_name" class="form-control" required placeholder="e.g. Rahul">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-warning small font-monospace">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="e.g. Sharma">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-warning small font-monospace">Mobile Number *</label>
                            <input type="tel" name="phone" class="form-control" required placeholder="+91 98765 43210">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-warning small font-monospace">Email Address *</label>
                            <input type="email" name="email" class="form-control" required placeholder="rahul@example.com">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-warning font-monospace small font-monospace">Target Course</label>
                            <select name="course_id" class="form-select font-monospace">
                                <?php foreach ($courses as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= Security::e($c['title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-warning font-monospace small font-monospace">Lead Source</label>
                            <select name="source" class="form-select font-monospace">
                                <option value="website_form">Website Form</option>
                                <option value="google_ads">Google Ads</option>
                                <option value="meta_ads">Meta Advantage+</option>
                                <option value="whatsapp">WhatsApp Cloud API</option>
                                <option value="walk_in">Walk-in / Front Desk</option>
                                <option value="referral">Student Referral</option>
                                <option value="inbound_call">Inbound Call</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-warning font-monospace small font-monospace">Assign Counselor *</label>
                            <select name="counselor_id" class="form-select font-monospace" required>
                                <?php foreach ($counselors as $cn): ?>
                                    <option value="<?= $cn['id'] ?>"><?= Security::e($cn['first_name'] . ' ' . $cn['last_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-line">
                    <button type="submit" class="btn btn-gold font-monospace w-100 py-2">Create & Assign Lead</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: CSV Bulk Import -->
<div class="modal fade" id="csvImportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-elevated text-light border">
            <div class="modal-header border-bottom border-line">
                <h5 class="modal-title font-monospace text-info"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Bulk Import Leads via CSV</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= Url::to('/admin/crm/leads/import') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <div class="modal-body">
                    <p class="text-secondary small">Upload a CSV file containing lead headers (<code>first_name</code>, <code>last_name</code>, <code>email</code>, <code>phone</code>). Automatic deduplication will run on Phone and Email.</p>
                    <div class="mb-3">
                        <label class="form-label text-warning small font-monospace">Select CSV File</label>
                        <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                    </div>
                </div>
                <div class="modal-footer border-top border-line">
                    <button type="submit" class="btn btn-info font-monospace text-dark w-100 py-2">Run Bulk Import & Dedupe</button>
                </div>
            </form>
        </div>
    </div>
</div>
