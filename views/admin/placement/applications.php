<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Student Job Applications & Interviews</h2>
        <p class="text-secondary small m-0">Track student applications: Applied → Shortlisted → Interview Scheduled → Offered</p>
    </div>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle m-0">
            <thead>
                <tr>
                    <th>Student Applicant</th>
                    <th>Job Title & Company</th>
                    <th>Resume File</th>
                    <th>Status</th>
                    <th>Applied Date</th>
                    <th class="text-end">Update Stage</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($applications)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No job applications submitted yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($applications as $app): ?>
                        <tr>
                            <td>
                                <div class="fw-semibold text-light"><?= Security::e($app['first_name'] . ' ' . $app['last_name']) ?></div>
                                <div class="font-monospace text-info small"><?= Security::e($app['email']) ?></div>
                            </td>
                            <td>
                                <div class="fw-semibold text-light"><?= Security::e($app['job_title']) ?></div>
                                <div class="font-monospace text-secondary small"><?= Security::e($app['company_name'] ?? 'Direct') ?></div>
                            </td>
                            <td>
                                <?php if (!empty($app['resume_file'])): ?>
                                    <a href="<?= Url::to('/' . $app['resume_file']) ?>" class="badge bg-secondary text-warning text-decoration-none" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
                                <?php else: ?>
                                    <span class="badge bg-dark text-muted">Profile Resume</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-info font-monospace"><?= strtoupper(str_replace('_', ' ', $app['status'])) ?></span></td>
                            <td class="small font-monospace text-muted"><?= Format::date($app['applied_at'], 'M d, Y') ?></td>
                            <td class="text-end">
                                <form action="<?= Url::to('/admin/placement/applications/' . $app['id'] . '/status') ?>" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                    <select name="status" class="form-select form-select-sm d-inline-block w-auto" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);" onchange="this.form.submit()">
                                        <option value="applied" <?= $app['status'] === 'applied' ? 'selected' : '' ?>>Applied</option>
                                        <option value="shortlisted" <?= $app['status'] === 'shortlisted' ? 'selected' : '' ?>>Shortlisted</option>
                                        <option value="interview_scheduled" <?= $app['status'] === 'interview_scheduled' ? 'selected' : '' ?>>Interview Scheduled</option>
                                        <option value="offered" <?= $app['status'] === 'offered' ? 'selected' : '' ?>>Offered</option>
                                        <option value="joined" <?= $app['status'] === 'joined' ? 'selected' : '' ?>>Joined</option>
                                        <option value="rejected" <?= $app['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
