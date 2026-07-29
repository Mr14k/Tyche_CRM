<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Faculty Showcase Manager</h2>
        <p class="text-secondary small m-0">Manage instructor bios, skills, and featured placement on the website</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-person-workspace"></i> Instructors List</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Faculty Name</th>
                            <th>Designation</th>
                            <th>Skills</th>
                            <th>Featured</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($facultyList as $fac): ?>
                            <tr>
                                <td class="fw-semibold text-light"><?= Security::e($fac['name']) ?></td>
                                <td class="small text-muted"><?= Security::e($fac['designation']) ?></td>
                                <td class="small text-info font-monospace"><?= Security::e($fac['skills']) ?></td>
                                <td>
                                    <?php if ($fac['is_featured']): ?>
                                        <span class="badge bg-warning text-dark">Featured</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Standard</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-plus-circle"></i> Add Faculty Profile</h5>
            <form action="<?= Url::to('/admin/cms/faculty') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Designation / Role Title</label>
                    <input type="text" name="designation" class="form-control" placeholder="e.g. Performance Marketing Manager" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Skills (Comma Separated)</label>
                    <input type="text" name="skills" class="form-control" placeholder="SEO, Meta Ads, Google Ads">
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Biography</label>
                    <textarea name="biography" class="form-control" rows="3" required></textarea>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featCheck">
                    <label class="form-check-label small text-light" for="featCheck">
                        Showcase as Featured Instructor on Homepage
                    </label>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4">Add Faculty Profile</button>
            </form>
        </div>
    </div>
</div>
