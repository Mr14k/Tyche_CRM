<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Student Course Enrollments</h2>
        <p class="text-secondary small m-0">Manage active student access and course enrollments</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-mortarboard"></i> Active Enrollments</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Enrolled Course</th>
                            <th>Enrolled Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enrollments as $en): ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold text-light"><?= Security::e($en['first_name'] . ' ' . $en['last_name']) ?></div>
                                    <div class="font-monospace text-info small"><?= Security::e($en['email']) ?></div>
                                </td>
                                <td>
                                    <div class="badge bg-warning text-dark font-monospace mb-1"><?= Security::e($en['code']) ?></div>
                                    <div class="small text-secondary"><?= Security::e($en['course_title']) ?></div>
                                </td>
                                <td class="small font-monospace text-muted"><?= Format::date($en['enrolled_at'], 'M d, Y') ?></td>
                                <td><span class="badge bg-success font-monospace">Active</span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-plus-circle"></i> Enroll Student into Course</h5>
            <form action="<?= Url::to('/admin/lms/enrollments') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Select Student Account</label>
                    <select name="user_id" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);" required>
                        <?php foreach ($students as $st): ?>
                            <option value="<?= $st['id'] ?>"><?= Security::e($st['first_name'] . ' ' . $st['last_name']) ?> (<?= Security::e($st['email']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Select Target Course</label>
                    <select name="course_id" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);" required>
                        <?php foreach ($courses as $c): ?>
                            <option value="<?= $c['id'] ?>">[<?= Security::e($c['code']) ?>] <?= Security::e($c['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4">Enroll Student</button>
            </form>
        </div>
    </div>
</div>
