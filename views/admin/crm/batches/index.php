<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Academic Cohort Batches & Seat Management</h2>
        <p class="text-secondary small m-0">Configure upcoming course batches, start dates, schedule types, and seat capacities</p>
    </div>
    <button type="button" class="btn btn-gold btn-sm px-3 font-monospace" data-bs-toggle="modal" data-bs-target="#newBatchModal">
        <i class="bi bi-plus-circle me-1"></i> Create New Batch
    </button>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom align-middle m-0" style="background:#161F2B !important; color:#F3EEE2 !important;">
            <thead>
                <tr>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Batch Name & Course</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Schedule Type</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Start Date</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Seats Filled</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Seat Capacity</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($batches)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No batches created yet. Click 'Create New Batch' to schedule one.</td></tr>
                <?php else: ?>
                    <?php foreach ($batches as $b): ?>
                        <tr style="background:#161F2B !important;">
                            <td style="background:#161F2B !important;">
                                <div class="fw-bold text-white fs-6"><?= Security::e($b['batch_name']) ?></div>
                                <div class="small text-secondary font-monospace"><?= Security::e($b['course_title']) ?></div>
                            </td>
                            <td style="background:#161F2B !important;">
                                <span class="badge bg-secondary font-monospace"><?= strtoupper($b['schedule_type']) ?> COHORT</span>
                            </td>
                            <td style="background:#161F2B !important;" class="font-monospace small text-light">
                                <?= Format::date($b['start_date'], 'M d, Y') ?>
                            </td>
                            <td style="background:#161F2B !important;">
                                <div class="fw-bold font-monospace text-gold fs-6"><?= (int)$b['seats_filled'] ?> Seats</div>
                            </td>
                            <td style="background:#161F2B !important;">
                                <div class="progress" style="height: 6px; width: 100px; background: #0F1620;">
                                    <?php $pct = round(((int)$b['seats_filled'] / (int)$b['capacity']) * 100); ?>
                                    <div class="progress-bar bg-success" style="width: <?= $pct ?>%;"></div>
                                </div>
                                <div class="small font-monospace text-muted mt-1"><?= (int)$b['seats_filled'] ?> / <?= (int)$b['capacity'] ?> (<?= $pct ?>%)</div>
                            </td>
                            <td style="background:#161F2B !important;">
                                <?php if ($b['status'] === 'active'): ?>
                                    <span class="badge bg-success font-monospace">ACTIVE</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark font-monospace">UPCOMING</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Create New Batch -->
<div class="modal fade" id="newBatchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-elevated text-light border">
            <div class="modal-header border-bottom border-line">
                <h5 class="modal-title font-monospace text-gold"><i class="bi bi-calendar-plus me-1"></i> Create Academic Cohort Batch</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= Url::to('/admin/crm/batches') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-warning small font-monospace">Select Course *</label>
                        <select name="course_id" class="form-select font-monospace" required>
                            <?php foreach ($courses as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= Security::e($c['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning small font-monospace">Batch Name *</label>
                        <input type="text" name="batch_name" class="form-control font-monospace" placeholder="e.g. SEO & AEO Mastery - Cohort Beta 2026" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label text-warning small font-monospace">Start Date *</label>
                            <input type="date" name="start_date" class="form-control font-monospace" required value="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-warning font-monospace small font-monospace">End Date</label>
                            <input type="date" name="end_date" class="form-control font-monospace" value="<?= date('Y-m-d', strtotime('+60 days')) ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-warning font-monospace small font-monospace">Schedule Type</label>
                            <select name="schedule_type" class="form-select font-monospace">
                                <option value="weekend">Weekend (Sat-Sun)</option>
                                <option value="weekday">Weekday (Mon-Fri)</option>
                                <option value="evening">Evening Fast-Track</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-warning small font-monospace">Seat Capacity *</label>
                            <input type="number" name="capacity" class="form-control font-monospace" value="30" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-line">
                    <button type="submit" class="btn btn-gold font-monospace w-100 py-2">Schedule Batch</button>
                </div>
            </form>
        </div>
    </div>
</div>
