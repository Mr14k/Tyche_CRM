<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">My Official Certificates & Credentials</h2>
        <p class="text-secondary small m-0">Issued upon 100% course completion and passed assessments</p>
    </div>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle m-0">
            <thead>
                <tr>
                    <th>Certificate Code</th>
                    <th>Course Title</th>
                    <th>Issue Date</th>
                    <th>Verification Hash</th>
                    <th class="text-end">Verification & Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($certificates)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No certificates earned yet. Complete all lessons and quizzes in your enrolled courses to unlock official certificates.</td></tr>
                <?php else: ?>
                    <?php foreach ($certificates as $cert): ?>
                        <tr>
                            <td class="fw-bold text-warning font-monospace"><?= Security::e($cert['certificate_code']) ?></td>
                            <td class="fw-semibold text-light"><?= Security::e($cert['course_title']) ?></td>
                            <td class="small font-monospace text-muted"><?= Format::date($cert['issue_date'], 'M d, Y') ?></td>
                            <td><code class="text-info font-monospace" style="font-size:11px;"><?= substr($cert['verification_hash'], 0, 16) ?>...</code></td>
                            <td class="text-end">
                                <a href="<?= Url::to('/verify-certificate/' . $cert['certificate_code']) ?>" target="_blank" class="btn btn-outline-warning btn-sm font-monospace"><i class="bi bi-shield-check"></i> Verify Public Credential</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
