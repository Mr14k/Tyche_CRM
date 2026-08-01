<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <span class="badge bg-gold text-dark font-monospace mb-1"><?= Security::e($lead['lead_code']) ?></span>
        <h2 class="h3 font-heading fw-bold text-white m-0"><?= Security::e($lead['first_name'] . ' ' . $lead['last_name']) ?></h2>
        <div class="text-secondary small font-monospace mt-1">
            <i class="bi bi-telephone text-warning me-1"></i> <?= Security::e($lead['phone']) ?> &bull; 
            <i class="bi bi-envelope text-info me-1"></i> <?= Security::e($lead['email']) ?>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= Url::to('/admin/crm/leads') ?>" class="btn btn-outline-secondary btn-sm text-light font-monospace">
            <i class="bi bi-arrow-left me-1"></i> Back to Pipeline
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Lead 360 Card & Stage Control -->
    <div class="col-lg-4">
        <!-- Lead Metadata -->
        <div class="card-custom p-4 mb-4">
            <h5 class="h6 font-monospace text-warning border-bottom border-line pb-2 mb-3">Lead Summary & Status</h5>
            
            <div class="mb-3">
                <div class="text-secondary small font-monospace">CURRENT LIFECYCLE STAGE</div>
                <div class="mt-1">
                    <?php
                    $statusBadge = match($lead['status']) {
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
                    <span class="badge <?= $statusBadge ?> font-monospace fs-6 px-3 py-2"><?= strtoupper(str_replace('_', ' ', $lead['status'])) ?></span>
                </div>
            </div>

            <?php if ($lead['status'] === 'lost'): ?>
                <div class="alert alert-danger font-monospace small mb-3">
                    <strong>Lost Reason:</strong> <?= strtoupper(str_replace('_', ' ', $lead['lost_reason'] ?? 'Other')) ?><br>
                    <span class="text-white"><?= Security::e($lead['lost_notes'] ?? '') ?></span>
                    <form action="<?= Url::to('/admin/crm/leads/' . $lead['id'] . '/reactivate') ?>" method="POST" class="mt-2">
                        <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                        <button type="submit" class="btn btn-sm btn-outline-light w-100 font-monospace"><i class="bi bi-arrow-clockwise me-1"></i> Re-activate Lead</button>
                    </form>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <div class="text-secondary small font-monospace">LEAD SCORE</div>
                <div class="progress my-1" style="height: 8px; background: #0F1620;">
                    <div class="progress-bar bg-warning" style="width: <?= (int)$lead['lead_score'] ?>%;"></div>
                </div>
                <div class="text-warning font-monospace fw-bold small"><?= (int)$lead['lead_score'] ?> / 100 Engagement Score</div>
            </div>

            <div class="mb-3">
                <div class="text-secondary small font-monospace">TARGET COURSE</div>
                <div class="fw-bold text-white"><?= Security::e($lead['course_title'] ?? 'Digital Marketing Executive') ?></div>
            </div>

            <div class="mb-3">
                <div class="text-secondary small font-monospace">ASSIGNED BATCH</div>
                <div class="fw-bold text-info small font-monospace"><?= Security::e($lead['batch_name'] ?? 'Cohort Alpha 2026') ?></div>
            </div>

            <div class="mb-3">
                <div class="text-secondary small font-monospace">ASSIGNED COUNSELOR</div>
                <div class="fw-bold text-light font-monospace"><?= Security::e(($lead['counselor_first'] ?? 'Unassigned') . ' ' . ($lead['counselor_last'] ?? '')) ?></div>
            </div>

            <div class="mb-0">
                <div class="text-secondary small font-monospace">SOURCE CHANNEL</div>
                <span class="badge bg-secondary font-monospace"><?= strtoupper(str_replace('_', ' ', $lead['source'])) ?></span>
            </div>
        </div>

        <!-- Lifecycle Stage Transition Controls -->
        <div class="card-custom p-4 mb-4">
            <h5 class="h6 font-monospace text-warning border-bottom border-line pb-2 mb-3">Update Lifecycle Stage</h5>
            <form action="<?= Url::to('/admin/crm/leads/' . $lead['id'] . '/stage') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small font-monospace">Select Target Stage</label>
                    <select name="status" id="stageSelect" class="form-select font-monospace">
                        <option value="contacted" <?= $lead['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                        <option value="qualified" <?= $lead['status'] === 'qualified' ? 'selected' : '' ?>>Qualified</option>
                        <option value="nurturing" <?= $lead['status'] === 'nurturing' ? 'selected' : '' ?>>Nurturing</option>
                        <option value="application_sent" <?= $lead['status'] === 'application_sent' ? 'selected' : '' ?>>Application Sent</option>
                        <option value="lost" <?= $lead['status'] === 'lost' ? 'selected' : '' ?>>Lost / Dropped</option>
                    </select>
                </div>

                <!-- Lost Reason Box (hidden unless Lost selected) -->
                <div id="lostReasonContainer" class="d-none mb-3">
                    <label class="form-label text-danger small font-monospace">Reason for Dropping Lead *</label>
                    <select name="lost_reason" class="form-select font-monospace mb-2">
                        <option value="no_response">No Response / Unreachable</option>
                        <option value="not_interested">Not Interested</option>
                        <option value="budget_issue">Budget / Fee High</option>
                        <option value="joined_elsewhere">Joined Competitor Academy</option>
                        <option value="course_mismatch">Course Curriculum Mismatch</option>
                        <option value="other">Other</option>
                    </select>
                    <textarea name="lost_notes" class="form-control font-monospace small" rows="2" placeholder="Provide notes regarding drop-off..."></textarea>
                </div>

                <button type="submit" class="btn btn-gold w-100 font-monospace py-2">Update Stage</button>
            </form>
        </div>

        <!-- Generator: Custom 18% GST Payment Link -->
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-gold border-bottom border-line pb-2 mb-3"><i class="bi bi-credit-card-2-front-fill me-1"></i> Generate Statutory Payment Link</h5>
            <form action="<?= Url::to('/admin/crm/leads/' . $lead['id'] . '/payment-link') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <input type="hidden" name="course_id" value="<?= $lead['course_id'] ?>">
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small font-monospace">Select Academic Batch</label>
                    <select name="batch_id" class="form-select font-monospace">
                        <?php foreach ($batches as $b): ?>
                            <option value="<?= $b['id'] ?>"><?= Security::e($b['batch_name']) ?> (Starts: <?= Format::date($b['start_date'], 'M d') ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning small font-monospace">Fee Amount (18% GST Inc.) *</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark text-warning border-secondary font-monospace">₹</span>
                        <input type="number" step="0.01" name="amount" class="form-control font-monospace fw-bold" value="<?= $lead['discount_price'] ?? $lead['price'] ?? 25000 ?>" required>

                    </div>
                </div>

                <button type="submit" class="btn btn-warning w-100 font-monospace py-2 text-dark fw-bold">
                    <i class="bi bi-send-fill me-1"></i> Generate & Send Payment Link
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: 360° Timeline Activity Feed & Quick Outreach Logger -->
    <div class="col-lg-8">
        <!-- Quick Outreach Logger -->
        <div class="card-custom p-4 mb-4">
            <h5 class="h6 font-monospace text-warning border-bottom border-line pb-2 mb-3"><i class="bi bi-telephone-outbound-fill me-1"></i> Click-to-Call & Multi-Channel Activity Logger</h5>
            <form action="#" method="POST" id="quickLogForm">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-warning font-monospace small font-monospace">Channel</label>
                        <select name="type" class="form-select font-monospace">
                            <option value="call">Click-to-Call (Phone)</option>
                            <option value="whatsapp">WhatsApp Cloud API</option>
                            <option value="email">Email Outreach</option>
                            <option value="note">Internal Counselor Note</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-warning font-monospace small font-monospace">Outcome Disposition</label>
                        <select name="outcome" class="form-select font-monospace">
                            <option value="connected">Call Connected / Spoke</option>
                            <option value="rnr">RNR (Ringing No Response)</option>
                            <option value="switched_off">Phone Switched Off</option>
                            <option value="busy">Line Busy</option>
                            <option value="sent">WhatsApp / Email Sent</option>
                            <option value="replied">Lead Replied</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-warning font-monospace small font-monospace">Call Duration (Sec)</label>
                        <input type="number" name="duration_seconds" class="form-control font-monospace" placeholder="180">
                    </div>
                    <div class="col-12">
                        <label class="form-label text-warning font-monospace small font-monospace">Activity Notes & Discussion Summary</label>
                        <textarea name="notes" class="form-control font-monospace small" rows="2" placeholder="Summarize call discussion or student questions..."></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-gold font-monospace px-4"><i class="bi bi-check-lg me-1"></i> Log Activity to Timeline</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- 360° Timeline Activity Feed -->
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-gold border-bottom border-line pb-3 mb-4"><i class="bi bi-clock-history me-1"></i> Lead 360° Interaction Timeline</h5>
            
            <?php if (empty($activities)): ?>
                <div class="text-center text-muted py-4">No activity logged for this lead yet.</div>
            <?php else: ?>
                <div class="timeline position-relative ps-4 border-start border-line space-y-4">
                    <?php foreach ($activities as $act): ?>
                        <div class="timeline-item position-relative mb-4">
                            <div class="position-absolute" style="left: -33px; top: 0;">
                                <?php if ($act['type'] === 'call'): ?>
                                    <span class="badge rounded-circle bg-warning p-2"><i class="bi bi-telephone-fill text-dark"></i></span>
                                <?php elseif ($act['type'] === 'whatsapp'): ?>
                                    <span class="badge rounded-circle bg-success p-2"><i class="bi bi-whatsapp"></i></span>
                                <?php elseif ($act['type'] === 'payment_link'): ?>
                                    <span class="badge rounded-circle bg-gold p-2"><i class="bi bi-credit-card-fill text-dark"></i></span>
                                <?php elseif ($act['type'] === 'stage_change'): ?>
                                    <span class="badge rounded-circle bg-primary p-2"><i class="bi bi-arrow-right-circle-fill"></i></span>
                                <?php else: ?>
                                    <span class="badge rounded-circle bg-info p-2"><i class="bi bi-journal-text text-dark"></i></span>
                                <?php endif; ?>
                            </div>

                            <div class="bg-elevated p-3 rounded-3 border border-line ms-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-white font-monospace small"><?= strtoupper($act['type']) ?> &bull; <?= strtoupper(str_replace('_', ' ', $act['outcome'] ?? 'LOGGED')) ?></span>
                                    <span class="text-muted small font-monospace"><?= Format::date($act['created_at'], 'M d, Y h:i A') ?></span>
                                </div>
                                <div class="text-light small"><?= Security::e($act['notes'] ?? '') ?></div>
                                <?php if (!empty($act['user_first'])): ?>
                                    <div class="text-secondary small font-monospace mt-2">Logged by: <?= Security::e($act['user_first'] . ' ' . $act['user_last']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.getElementById('stageSelect').addEventListener('change', function() {
    if (this.value === 'lost') {
        document.getElementById('lostReasonContainer').classList.remove('d-none');
    } else {
        document.getElementById('lostReasonContainer').classList.add('d-none');
    }
});
</script>
