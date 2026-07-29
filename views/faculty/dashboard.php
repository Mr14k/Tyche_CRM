<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Faculty Teaching Workspace</h2>
        <p class="text-secondary small m-0">Manage assigned courses, evaluate student projects, and publish course announcements</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-journal-bookmark"></i> My Assigned Courses</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Code & Course Title</th>
                            <th>Role</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($assignedCourses)): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">No courses assigned.</td></tr>
                        <?php else: ?>
                            <?php foreach ($assignedCourses as $c): ?>
                                <tr>
                                    <td>
                                        <div class="badge bg-warning text-dark font-monospace mb-1"><?= Security::e($c['code']) ?></div>
                                        <div class="fw-semibold text-light"><?= Security::e($c['title']) ?></div>
                                    </td>
                                    <td><span class="badge bg-info font-monospace"><?= strtoupper($c['instructor_role']) ?></span></td>
                                    <td class="text-end">
                                        <a href="<?= Url::to('/admin/lms/courses/' . $c['id'] . '/edit') ?>" class="btn btn-outline-warning btn-sm" title="Edit Course Hierarchy"><i class="bi bi-diagram-3"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-file-earmark-check"></i> Pending Student Assignment Reviews</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Assignment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pendingSubmissions)): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">No pending submissions.</td></tr>
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
