<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Assignment Review & Grading Hub</h2>
        <p class="text-secondary small m-0">Review student capstone projects, grade submissions, and assign feedback</p>
    </div>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle m-0">
            <thead>
                <tr>
                    <th>Student Name & Email</th>
                    <th>Assignment & Course</th>
                    <th>Submission Resource</th>
                    <th>Marks Awarded</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($submissions)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No student assignment submissions found.</td></tr>
                <?php else: ?>
                    <?php foreach ($submissions as $sub): ?>
                        <tr>
                            <td>
                                <div class="fw-semibold text-light"><?= Security::e($sub['first_name'] . ' ' . $sub['last_name']) ?></div>
                                <div class="font-monospace text-info small"><?= Security::e($sub['email']) ?></div>
                            </td>
                            <td>
                                <div class="fw-semibold text-light small"><?= Security::e($sub['assignment_title']) ?></div>
                                <div class="text-muted" style="font-size:11px;"><?= Security::e($sub['course_title']) ?></div>
                            </td>
                            <td class="font-monospace text-warning small">
                                <?php if ($sub['github_url']): ?>
                                    <a href="<?= Security::e($sub['github_url']) ?>" target="_blank" class="text-info"><i class="bi bi-github"></i> View Repository</a>
                                <?php else: ?>
                                    Text Content
                                <?php endif; ?>
                            </td>
                            <td class="font-monospace text-warning fw-bold">
                                <?= $sub['marks_awarded'] !== null ? $sub['marks_awarded'] . ' / 100' : '—' ?>
                            </td>
                            <td>
                                <?php if ($sub['status'] === 'graded'): ?>
                                    <span class="badge bg-success">Graded</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Submitted</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-gold btn-sm py-0 px-2 font-monospace" data-bs-toggle="modal" data-bs-target="#gradeModal<?= $sub['id'] ?>">
                                    <i class="bi bi-check-lg"></i> Grade
                                </button>

                                <!-- Modal: Grade Submission -->
                                <div class="modal fade" id="gradeModal<?= $sub['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog text-start">
                                        <div class="modal-content" style="background:#161F2B; color:#F3EEE2; border:1px solid rgba(243,238,226,0.14);">
                                            <div class="modal-header border-secondary">
                                                <h5 class="modal-title font-monospace text-warning">Grade Assignment Submission</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="<?= Url::to('/faculty/assignments/' . $sub['id'] . '/grade') ?>" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">Marks Awarded (Out of 100)</label>
                                                        <input type="number" name="marks_awarded" class="form-control font-monospace" value="<?= $sub['marks_awarded'] ?? 85 ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">Status</label>
                                                        <select name="status" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                                                            <option value="graded" selected>Approved & Graded</option>
                                                            <option value="resubmission_requested">Request Resubmission</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-muted small">Faculty Feedback Notes</label>
                                                        <textarea name="feedback_notes" class="form-control" rows="3" placeholder="Great work on the technical audit structure..."><?= Security::e($sub['feedback_notes'] ?? '') ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-secondary">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-gold btn-sm">Save Grade & Feedback</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
