<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">My Live Class Timetable & Digital Classroom</h2>
        <p class="text-secondary small m-0">Join live lectures, view upcoming class schedules, and access digital classroom streams</p>
    </div>
</div>

<div class="card-custom p-4 mb-4">
    <div class="table-responsive">
        <table class="table table-custom align-middle m-0" style="background:#161F2B !important;">
            <thead>
                <tr>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Date & Timing</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Lecture Topic & Subject</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Faculty Instructor</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Status</th>
                    <th class="text-end" style="background:#0F1620 !important; color:#D9AE68 !important;">Digital Classroom</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($schedules)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No live or upcoming classes scheduled for your enrolled batch right now.</td></tr>
                <?php else: ?>
                    <?php foreach ($schedules as $s): ?>
                        <tr style="background:#161F2B !important;">
                            <td style="background:#161F2B !important;" class="font-monospace small">
                                <div class="fw-bold text-info"><i class="bi bi-calendar-event me-1"></i> <?= date('D, d M Y', strtotime($s['schedule_date'])) ?></div>
                                <div class="text-light"><i class="bi bi-clock me-1"></i> <?= date('h:i A', strtotime($s['start_time'])) ?> - <?= date('h:i A', strtotime($s['end_time'])) ?></div>
                            </td>
                            <td style="background:#161F2B !important;">
                                <div class="fw-bold text-light"><?= Security::e($s['title']) ?></div>
                                <div class="small font-monospace text-warning"><?= Security::e($s['course_title']) ?></div>
                            </td>
                            <td style="background:#161F2B !important;" class="font-monospace small text-light">
                                <i class="bi bi-person-badge text-gold me-1"></i> <?= Security::e($s['faculty_first'] . ' ' . $s['faculty_last']) ?>
                            </td>
                            <td style="background:#161F2B !important;">
                                <?php if ($s['status'] === 'live'): ?>
                                    <span class="badge bg-danger text-white font-monospace animate-pulse"><i class="bi bi-record-fill me-1"></i> LIVE NOW</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark font-monospace">SCHEDULED</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end" style="background:#161F2B !important;">
                                <?php if (!empty($s['meeting_link'])): ?>
                                    <a href="<?= Security::e($s['meeting_link']) ?>" target="_blank" class="btn <?= $s['status'] === 'live' ? 'btn-danger animate-pulse' : 'btn-gold' ?> btn-sm font-monospace px-3">
                                        <i class="bi bi-camera-video-fill me-1"></i> <?= $s['status'] === 'live' ? 'Join Live Stream' : 'Join Classroom' ?>
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-secondary font-monospace">Link Pending</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
