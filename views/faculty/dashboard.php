<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Faculty Teaching Workspace</h2>
        <p class="text-secondary small m-0">Schedule classes, launch digital classrooms, track weekly teaching metrics, and evaluate student work</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= Url::to('/faculty/schedules') ?>" class="btn btn-outline-info btn-sm font-monospace">
            <i class="bi bi-calendar3 me-1"></i> Full Timetable
        </a>
        <button type="button" class="btn btn-gold btn-sm px-3 font-monospace" data-bs-toggle="modal" data-bs-target="#scheduleClassModal">
            <i class="bi bi-plus-circle me-1"></i> Schedule Class
        </button>
    </div>
</div>

<!-- Faculty Telemetry & Teaching Analytics Banner -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card-custom p-3 text-center border-start border-4 border-warning">
            <div class="text-secondary small font-monospace">CLASSES SCHEDULED (THIS WEEK)</div>
            <div class="fs-3 fw-bold text-warning font-monospace my-1"><?= number_format($telemetry['weekly_scheduled'] ?? 0) ?></div>
            <div class="text-light small"><i class="bi bi-calendar-check text-warning me-1"></i> Mon - Sun Timetable</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card-custom p-3 text-center border-start border-4 border-info">
            <div class="text-secondary small font-monospace">ASSIGNED BATCHES & COURSES</div>
            <div class="fs-3 fw-bold text-info font-monospace my-1"><?= number_format($telemetry['assigned_batches_count'] ?? 0) ?></div>
            <div class="text-info small"><i class="bi bi-people-fill me-1"></i> Active Teaching Squads</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card-custom p-3 text-center border-start border-4 border-success">
            <div class="text-secondary small font-monospace">CLASSES TAKEN (THIS MONTH)</div>
            <div class="fs-3 fw-bold text-success font-monospace my-1">
                <?= number_format($telemetry['monthly_completed'] ?? 0) ?> <span class="fs-6 text-muted">/ <?= number_format($telemetry['monthly_scheduled'] ?? 0) ?></span>
            </div>
            <div class="text-success small font-monospace"><i class="bi bi-check-circle-fill me-1"></i> <?= $telemetry['monthly_completion_pct'] ?? 0 ?>% Completion Rate</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card-custom p-3 text-center border-start border-4 border-gold">
            <div class="text-secondary small font-monospace">PENDING ASSIGNMENT REVIEWS</div>
            <div class="fs-3 fw-bold text-gold font-monospace my-1"><?= number_format(count($pendingSubmissions ?? [])) ?></div>
            <div class="text-gold small"><i class="bi bi-hourglass-split me-1"></i> Awaiting Grading</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Upcoming Classes & Timings Widget -->
    <div class="col-md-7">
        <div class="card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="h6 font-monospace text-warning m-0"><i class="bi bi-broadcast me-2"></i> Upcoming Scheduled Classes & Timings</h5>
                <a href="<?= Url::to('/faculty/schedules') ?>" class="btn btn-link btn-sm text-gold p-0 font-monospace text-decoration-none">View All →</a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom align-middle m-0" style="background:#161F2B !important;">
                    <thead>
                        <tr>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Lecture Topic & Course</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Batch</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Date & Timing</th>
                            <th class="text-end" style="background:#0F1620 !important; color:#D9AE68 !important;">Digital Classroom</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($upcomingClasses)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No upcoming classes scheduled. Click "+ Schedule Class" to create one.</td></tr>
                        <?php else: ?>
                            <?php foreach ($upcomingClasses as $cls): ?>
                                <tr style="background:#161F2B !important;">
                                    <td style="background:#161F2B !important;">
                                        <div class="fw-bold text-light"><?= Security::e($cls['title']) ?></div>
                                        <div class="small font-monospace text-warning"><?= Security::e($cls['course_title']) ?> (<?= Security::e($cls['course_code']) ?>)</div>
                                    </td>
                                    <td style="background:#161F2B !important;">
                                        <span class="badge bg-secondary font-monospace"><?= Security::e($cls['batch_name'] ?? 'All Batches') ?></span>
                                    </td>
                                    <td style="background:#161F2B !important;" class="font-monospace small">
                                        <div class="text-info"><i class="bi bi-calendar-event me-1"></i> <?= date('D, d M Y', strtotime($cls['schedule_date'])) ?></div>
                                        <div class="text-light"><i class="bi bi-clock me-1"></i> <?= date('h:i A', strtotime($cls['start_time'])) ?> - <?= date('h:i A', strtotime($cls['end_time'])) ?></div>
                                    </td>
                                    <td class="text-end" style="background:#161F2B !important;">
                                        <?php if ($cls['status'] === 'live'): ?>
                                            <span class="badge bg-danger text-white font-monospace animate-pulse me-2"><i class="bi bi-record-fill me-1"></i> LIVE NOW</span>
                                            <a href="<?= Security::e($cls['meeting_link']) ?>" target="_blank" class="btn btn-danger btn-sm font-monospace px-3 me-1">
                                                <i class="bi bi-camera-video-fill me-1"></i> Join Room
                                            </a>
                                            <form action="<?= Url::to('/faculty/schedules/' . $cls['id'] . '/go-live') ?>" method="POST" class="d-inline">
                                                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                                <button type="submit" class="btn btn-outline-secondary btn-sm font-monospace" title="End Class">End</button>
                                            </form>
                                        <?php else: ?>
                                            <form action="<?= Url::to('/faculty/schedules/' . $cls['id'] . '/go-live') ?>" method="POST" class="d-inline">
                                                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                                <button type="submit" class="btn btn-gold btn-sm px-3 font-monospace">
                                                    <i class="bi bi-broadcast me-1"></i> Go Live
                                                </button>
                                            </form>
                                            <?php if (!empty($cls['meeting_link'])): ?>
                                                <a href="<?= Security::e($cls['meeting_link']) ?>" target="_blank" class="btn btn-outline-info btn-sm font-monospace ms-1" title="Open Room URL">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Upcoming Quizzes & Exams Widget -->
    <div class="col-md-5">
        <div class="card-custom p-4 h-100">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-card-checklist me-2"></i> Upcoming Quizzes & Exams</h5>
            <div class="table-responsive">
                <table class="table table-custom align-middle m-0" style="background:#161F2B !important;">
                    <thead>
                        <tr>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Quiz / Exam Title</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Course / Code</th>
                            <th style="background:#0F1620 !important; color:#D9AE68 !important;">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($upcomingQuizzes)): ?>
                            <tr><td colspan="3" class="text-center text-muted py-4">No upcoming quizzes configured for your assigned courses.</td></tr>
                        <?php else: ?>
                            <?php foreach ($upcomingQuizzes as $qz): ?>
                                <tr style="background:#161F2B !important;">
                                    <td style="background:#161F2B !important;">
                                        <div class="fw-bold text-light small"><?= Security::e($qz['title']) ?></div>
                                        <div class="small font-monospace text-muted">Pass Score: <?= (int)$qz['passing_score_percentage'] ?>%</div>
                                    </td>
                                    <td style="background:#161F2B !important;">
                                        <span class="badge bg-secondary font-monospace"><?= Security::e($qz['course_code']) ?></span>
                                    </td>
                                    <td style="background:#161F2B !important;" class="font-monospace small text-info">
                                        <i class="bi bi-clock-history me-1"></i> <?= (int)$qz['time_limit_minutes'] ?> Mins
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- My Assigned Courses -->
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-journal-bookmark me-2"></i> My Assigned Courses</h5>
            <div class="table-responsive">
                <table class="table table-custom align-middle m-0">
                    <thead>
                        <tr>
                            <th>Code & Course Title</th>
                            <th>Role</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($assignedCourses)): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">No courses assigned to your profile yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($assignedCourses as $c): ?>
                                <tr>
                                    <td>
                                        <div class="badge bg-warning text-dark font-monospace mb-1"><?= Security::e($c['code']) ?></div>
                                        <div class="fw-semibold text-light"><?= Security::e($c['title']) ?></div>
                                    </td>
                                    <td><span class="badge bg-info font-monospace"><?= strtoupper($c['instructor_role']) ?></span></td>
                                    <td class="text-end">
                                        <a href="<?= Url::to('/admin/lms/courses/' . $c['id'] . '/edit') ?>" class="btn btn-outline-warning btn-sm" title="Edit Course Content"><i class="bi bi-diagram-3"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pending Student Assignment Reviews -->
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-file-earmark-check me-2"></i> Pending Student Assignment Reviews</h5>
            <div class="table-responsive">
                <table class="table table-custom align-middle m-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Assignment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pendingSubmissions)): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">No pending submissions to grade.</td></tr>
                        <?php else: ?>
                            <?php foreach (array_slice($pendingSubmissions, 0, 5) as $sub): ?>
                                <tr>
                                    <td class="fw-semibold text-light small"><?= Security::e($sub['first_name'] . ' ' . $sub['last_name']) ?></td>
                                    <td class="small text-secondary"><?= Security::e($sub['assignment_title']) ?></td>
                                    <td><span class="badge bg-warning text-dark font-monospace"><?= Security::e($sub['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <a href="<?= Url::to('/faculty/assignments') ?>" class="btn btn-gold btn-sm w-100 font-monospace mt-3">Go to Assignment Review Hub →</a>
        </div>
    </div>
</div>

<!-- Modal: Schedule Class -->
<div class="modal fade" id="scheduleClassModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-elevated text-light border">
            <div class="modal-header border-bottom border-line">
                <h5 class="modal-title font-monospace text-gold"><i class="bi bi-calendar-plus me-1"></i> Schedule Class & Generate Digital Room</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= Url::to('/faculty/schedules/store') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <input type="hidden" name="redirect_back" value="<?= Security::e(Url::to('/faculty/dashboard')) ?>">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-warning small font-monospace">Target Course / Subject *</label>
                            <select name="course_id" class="form-select font-monospace" required>
                                <option value="">-- Select Course --</option>
                                <?php foreach ($assignedCourses as $ac): ?>
                                    <option value="<?= $ac['id'] ?>"><?= Security::e($ac['title']) ?> (<?= Security::e($ac['code']) ?>)</option>
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
                        <div class="col-12">
                            <label class="form-label text-warning small font-monospace">Lecture Topic / Title *</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. Chapter 4: React State Management & Hooks">
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
                        <div class="col-md-6">
                            <label class="form-label text-warning small font-monospace">Digital Classroom Provider</label>
                            <select name="meeting_provider" class="form-select font-monospace">
                                <option value="jitsi">Jitsi Meet (Auto-Generated HD Room)</option>
                                <option value="google_meet">Google Meet</option>
                                <option value="zoom">Zoom Video</option>
                                <option value="custom">Custom WebRTC / Live Stream URL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-warning small font-monospace">Custom Meeting Link (Optional)</label>
                            <input type="url" name="meeting_link" class="form-control font-monospace" placeholder="Leave blank to auto-generate Jitsi link">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-warning small font-monospace">Class Agenda / Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Brief topics to cover, required prep materials..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-line">
                    <button type="submit" class="btn btn-gold font-monospace w-100 py-2">
                        <i class="bi bi-calendar-check me-1"></i> Schedule Class & Generate Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
