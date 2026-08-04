<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Institute Class Timetables & Live Rooms</h2>
        <p class="text-secondary small m-0">Schedule classes for faculty across all batches and courses, manage digital classrooms</p>
    </div>
    <button type="button" class="btn btn-gold btn-sm px-3 font-monospace" data-bs-toggle="modal" data-bs-target="#adminScheduleModal">
        <i class="bi bi-plus-circle me-1"></i> Schedule Class for Faculty
    </button>
</div>

<!-- Timetable Table -->
<div class="card-custom p-4 mb-4">
    <div class="table-responsive">
        <table class="table table-custom align-middle m-0" style="background:#161F2B !important;">
            <thead>
                <tr>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Date & Timing</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Lecture Topic & Course</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Faculty Instructor</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Batch</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Status</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Digital Room Link</th>
                    <th class="text-end" style="background:#0F1620 !important; color:#D9AE68 !important;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($schedules)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">No classes scheduled across the institute yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($schedules as $s): ?>
                        <tr style="background:#161F2B !important;">
                            <td style="background:#161F2B !important;" class="font-monospace small">
                                <div class="fw-bold text-info"><i class="bi bi-calendar-event me-1"></i> <?= date('D, d M Y', strtotime($s['schedule_date'])) ?></div>
                                <div class="text-light"><i class="bi bi-clock me-1"></i> <?= date('h:i A', strtotime($s['start_time'])) ?> - <?= date('h:i A', strtotime($s['end_time'])) ?></div>
                            </td>
                            <td style="background:#161F2B !important;">
                                <div class="fw-bold text-light"><?= Security::e($s['title']) ?></div>
                                <div class="small font-monospace text-warning"><?= Security::e($s['course_title']) ?> (<?= Security::e($s['course_code']) ?>)</div>
                            </td>
                            <td style="background:#161F2B !important;" class="font-monospace small text-light">
                                <i class="bi bi-person-badge text-gold me-1"></i> <?= Security::e($s['faculty_first'] . ' ' . $s['faculty_last']) ?>
                            </td>
                            <td style="background:#161F2B !important;">
                                <span class="badge bg-secondary font-monospace"><?= Security::e($s['batch_name'] ?? 'All Batches') ?></span>
                            </td>
                            <td style="background:#161F2B !important;">
                                <?php
                                $badge = match($s['status']) {
                                    'live' => 'bg-danger text-white animate-pulse',
                                    'scheduled' => 'bg-warning text-dark',
                                    'completed' => 'bg-success text-white',
                                    'cancelled' => 'bg-secondary text-white',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <span class="badge <?= $badge ?> font-monospace"><?= strtoupper($s['status']) ?></span>
                            </td>
                            <td style="background:#161F2B !important;" class="font-monospace small">
                                <?php if (!empty($s['meeting_link'])): ?>
                                    <a href="<?= Security::e($s['meeting_link']) ?>" target="_blank" class="text-gold text-decoration-none">
                                        <i class="bi bi-camera-video me-1"></i> Open Digital Room
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Not generated</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end" style="background:#161F2B !important;">
                                <form action="<?= Url::to('/admin/lms/schedules/' . $s['id'] . '/go-live') ?>" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                    <button type="submit" class="btn <?= $s['status'] === 'live' ? 'btn-outline-danger' : 'btn-gold' ?> btn-sm font-monospace">
                                        <?= $s['status'] === 'live' ? 'End Class' : 'Toggle Live' ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Admin Schedule Class for Faculty -->
<div class="modal fade" id="adminScheduleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-elevated text-light border">
            <div class="modal-header border-bottom border-line">
                <h5 class="modal-title font-monospace text-gold"><i class="bi bi-calendar-plus me-1"></i> Schedule Class for Faculty Member</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= Url::to('/admin/lms/schedules') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-warning small font-monospace">Select Faculty Member *</label>
                            <select name="faculty_id" class="form-select font-monospace" required>
                                <option value="">-- Choose Instructor --</option>
                                <?php foreach ($facultyList as $f): ?>
                                    <option value="<?= $f['id'] ?>"><?= Security::e($f['first_name'] . ' ' . $f['last_name']) ?> (<?= Security::e($f['email']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-warning small font-monospace">Target Course / Subject *</label>
                            <select name="course_id" class="form-select font-monospace" required>
                                <option value="">-- Select Course --</option>
                                <?php foreach ($courses as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= Security::e($c['title']) ?> (<?= Security::e($c['code']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-warning small font-monospace">Target Student Batch (Optional)</label>
                            <select name="batch_id" class="form-select font-monospace">
                                <option value="">-- All Batches --</option>
                                <?php foreach ($batches as $b): ?>
                                    <option value="<?= $b['id'] ?>"><?= Security::e($b['batch_name']) ?> (<?= Security::e($b['course_title']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-warning small font-monospace">Digital Classroom Provider</label>
                            <select name="meeting_provider" class="form-select font-monospace">
                                <option value="jitsi">Jitsi Meet (Auto-Generated HD Room)</option>
                                <option value="google_meet">Google Meet</option>
                                <option value="zoom">Zoom Video</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-warning small font-monospace">Lecture Topic / Title *</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. Chapter 1: Introduction to Web Design">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-warning small font-monospace">Schedule Date *</label>
                            <input type="date" name="schedule_date" class="form-control font-monospace" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-warning small font-monospace">Start Time *</label>
                            <input type="time" name="start_time" class="form-control font-monospace" required value="10:00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-warning small font-monospace">End Time *</label>
                            <input type="time" name="end_time" class="form-control font-monospace" required value="11:30">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-line">
                    <button type="submit" class="btn btn-gold font-monospace w-100 py-2">
                        <i class="bi bi-calendar-check me-1"></i> Assign Schedule & Generate Room Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
