<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">LMS Academic Course Directory</h2>
        <p class="text-secondary small m-0">Build courses, modules, chapters, and video lessons with progress tracking</p>
    </div>
    <a href="<?= Url::to('/admin/lms/courses/create') ?>" class="btn btn-gold btn-sm px-3">
        <i class="bi bi-journal-plus"></i> Build New Course
    </a>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom align-middle m-0" style="background:#161F2B !important; color:#F3EEE2 !important;">
            <thead>
                <tr>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Code & Course Title</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Category</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Price</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Sequential Locking</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Status</th>
                    <th class="text-end" style="background:#0F1620 !important; color:#D9AE68 !important;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($courses)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No academic courses created yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($courses as $c): ?>
                        <tr style="background:#161F2B !important;">
                            <td style="background:#161F2B !important; color:#F3EEE2 !important;">
                                <div class="badge bg-dark text-warning border border-warning font-monospace mb-1 px-2 py-1"><?= Security::e($c['code']) ?></div>
                                <div class="fw-bold text-white fs-6"><?= Security::e($c['title']) ?></div>
                            </td>
                            <td style="background:#161F2B !important;"><span class="badge bg-secondary font-monospace"><?= Security::e($c['category_name'] ?? 'General') ?></span></td>
                            <td style="background:#161F2B !important;" class="font-monospace text-warning fw-bold">₹ <?= number_format((float)$c['price'], 2) ?></td>
                            <td style="background:#161F2B !important;">
                                <?php if ($c['allow_skip_lessons']): ?>
                                    <span class="badge bg-info text-dark">Free Navigation</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-lock-fill me-1"></i> Strict Sequential</span>
                                <?php endif; ?>
                            </td>
                            <td style="background:#161F2B !important;">
                                <?php if ($c['status'] === 'published'): ?>
                                    <span class="badge bg-success">Published</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end" style="background:#161F2B !important;">
                                <a href="<?= Url::to('/courses/' . $c['slug']) ?>" target="_blank" class="btn btn-outline-info btn-sm me-1" title="View Public Course Landing Page"><i class="bi bi-eye"></i></a>
                                <a href="<?= Url::to('/admin/lms/courses/' . $c['id'] . '/edit') ?>" class="btn btn-outline-warning btn-sm me-1" title="Edit Course Details & Hierarchy"><i class="bi bi-diagram-3"></i> Edit Course</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
