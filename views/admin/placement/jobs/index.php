<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Placement Cell Job Openings Board</h2>
        <p class="text-secondary small m-0">Post career openings from hiring partners (Swiggy, Zomato, Google, Meta Partners)</p>
    </div>
    <button class="btn btn-gold btn-sm px-3" data-bs-toggle="modal" data-bs-target="#addJobModal">
        <i class="bi bi-plus-circle-fill me-1"></i> Post New Job Opening
    </button>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle m-0">
            <thead>
                <tr>
                    <th>Job Title & Company</th>
                    <th>Type & Location</th>
                    <th>Salary Range</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($jobs)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No active job openings posted.</td></tr>
                <?php else: ?>
                    <?php foreach ($jobs as $j): ?>
                        <tr>
                            <td>
                                <div class="fw-semibold text-light"><?= Security::e($j['title']) ?></div>
                                <div class="font-monospace text-info small"><?= Security::e($j['company_name'] ?? 'Direct Hiring') ?></div>
                            </td>
                            <td>
                                <span class="badge bg-info font-monospace"><?= strtoupper($j['type']) ?></span>
                                <span class="text-secondary small ms-1"><?= Security::e($j['location']) ?></span>
                            </td>
                            <td class="font-monospace text-warning fw-bold"><?= Security::e($j['salary_range']) ?></td>
                            <td class="small font-monospace text-muted"><?= Format::date($j['deadline'], 'M d, Y') ?></td>
                            <td><span class="badge bg-success font-monospace">ACTIVE</span></td>
                            <td class="text-end">
                                <a href="<?= Url::to('/jobs/' . $j['slug']) ?>" class="btn btn-outline-warning btn-sm" target="_blank"><i class="bi bi-eye"></i> View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Post Job Opening -->
<div class="modal fade" id="addJobModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background:#161F2B; color:#F3EEE2; border:1px solid rgba(243,238,226,0.14);">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-monospace text-warning">Post Placement Job Opening</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= Url::to('/admin/placement/jobs') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                    
                    <div class="row g-2 mb-3">
                        <div class="col-8">
                            <label class="form-label text-warning font-monospace small">Job Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Performance Marketing Manager" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-warning font-monospace small">Employer Company</label>
                            <select name="employer_id" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                                <?php foreach ($employers as $e): ?>
                                    <option value="<?= $e['id'] ?>"><?= Security::e($e['company_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label text-warning font-monospace small">Job Type</label>
                            <select name="type" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                                <option value="full_time">Full Time</option>
                                <option value="internship">Internship</option>
                                <option value="freelance">Freelance</option>
                                <option value="remote">Remote</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-warning font-monospace small">Location</label>
                            <input type="text" name="location" class="form-control" value="Bangalore" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-warning font-monospace small">Salary Package</label>
                            <input type="text" name="salary_range" class="form-control font-monospace" placeholder="e.g. ₹6 - ₹9 LPA" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Job Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Requirements & Qualifications</label>
                        <textarea name="requirements" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold btn-sm">Publish Job Opening</button>
                </div>
            </form>
        </div>
    </div>
</div>
