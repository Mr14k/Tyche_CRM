<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Assignments & Capstone Submissions</h2>
        <p class="text-secondary small m-0">Submit GitHub repositories, technical audit reports, and view faculty grades</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-file-earmark-check"></i> My Assignment Submissions</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Assignment</th>
                            <th>Submission Link</th>
                            <th>Score</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($submissions)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No assignments submitted yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($submissions as $sub): ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-light"><?= Security::e($sub['assignment_title']) ?></div>
                                        <div class="text-muted small"><?= Security::e($sub['course_title']) ?></div>
                                    </td>
                                    <td class="font-monospace text-info small">
                                        <?php if ($sub['github_url']): ?>
                                            <a href="<?= Security::e($sub['github_url']) ?>" target="_blank" class="text-info"><i class="bi bi-github"></i> GitHub Repo</a>
                                        <?php else: ?>
                                            Text Submission
                                        <?php endif; ?>
                                    </td>
                                    <td class="font-monospace text-warning">
                                        <?= $sub['marks_awarded'] !== null ? $sub['marks_awarded'] . ' / ' . $sub['max_marks'] : 'Pending Review' ?>
                                    </td>
                                    <td>
                                        <?php if ($sub['status'] === 'graded'): ?>
                                            <span class="badge bg-success">Graded</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Under Review</span>
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

    <div class="col-md-5">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-upload"></i> Submit New Assignment</h5>
            <form action="<?= Url::to('/student/assignments') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="mb-3">
                    <label class="form-label text-muted small">Select Assignment</label>
                    <select name="assignment_id" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);" required>
                        <?php foreach ($assignments as $a): ?>
                            <option value="<?= $a['id'] ?>">[<?= Security::e($a['course_title']) ?>] <?= Security::e($a['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small">Submission Type</label>
                    <select name="submission_type" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="github_url">GitHub Repository Link</option>
                        <option value="drive_url">Google Drive / Cloud URL</option>
                        <option value="text">Written Strategy Text</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small">GitHub / Resource URL</label>
                    <input type="url" name="github_url" class="form-control font-monospace" placeholder="https://github.com/username/project">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small">Submission Text / Notes</label>
                    <textarea name="submission_text" class="form-control font-monospace" rows="3" placeholder="Additional details or implementation notes..."></textarea>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4 font-monospace"><i class="bi bi-send"></i> Submit to Faculty Workspace</button>
            </form>
        </div>
    </div>
</div>
