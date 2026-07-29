<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Student Digital Classroom</h2>
        <p class="text-secondary small m-0">Monitor learning streaks, enrolled courses, certificates, and announcements</p>
    </div>
    <a href="<?= Url::to('/courses') ?>" class="btn btn-gold btn-sm px-3"><i class="bi bi-journal-plus"></i> Browse Courses</a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-4 text-center">
            <i class="bi bi-journal-bookmark-fill text-warning display-5 mb-2"></i>
            <div class="h3 font-monospace text-light mb-0"><?= count($enrollments) ?></div>
            <div class="text-muted small">Enrolled Courses</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 text-center">
            <i class="bi bi-award-fill text-gold display-5 mb-2"></i>
            <div class="h3 font-monospace text-light mb-0"><?= count($certificates) ?></div>
            <div class="text-muted small">Official Certificates</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 text-center">
            <i class="bi bi-lightning-charge-fill text-info display-5 mb-2"></i>
            <div class="h3 font-monospace text-light mb-0"><?= count($achievements) ?></div>
            <div class="text-muted small">Achievements & Badges</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 text-center">
            <i class="bi bi-fire text-danger display-5 mb-2"></i>
            <div class="h3 font-monospace text-light mb-0">5 Days</div>
            <div class="text-muted small">Active Learning Streak</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-play-circle-fill"></i> Continue Learning</h5>
            <div class="row g-3">
                <?php if (empty($enrollments)): ?>
                    <div class="text-center text-muted py-4">You are not enrolled in any courses. Explore the catalog to begin!</div>
                <?php else: ?>
                    <?php foreach ($enrollments as $e): ?>
                        <div class="col-md-6">
                            <div class="p-3 bg-dark border border-secondary rounded h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="badge bg-warning text-dark font-monospace mb-2"><?= Security::e($e['code']) ?></span>
                                    <h5 class="h6 text-light fw-bold mb-2"><?= Security::e($e['title']) ?></h5>
                                    <div class="text-muted small mb-3">Enrolled: <?= Format::date($e['enrolled_at'], 'M d, Y') ?></div>
                                </div>
                                <a href="<?= Url::to('/courses/' . $e['slug']) ?>" class="btn btn-gold btn-sm w-100 font-monospace">Launch Course Player →</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-megaphone-fill"></i> Announcements</h5>
            <?php if (empty($announcements)): ?>
                <div class="text-center text-muted py-3 small">No course announcements.</div>
            <?php else: ?>
                <?php foreach ($announcements as $anc): ?>
                    <div class="border-bottom border-secondary pb-2 mb-2">
                        <div class="fw-bold text-light small"><?= Security::e($anc['title']) ?></div>
                        <div class="text-secondary small"><?= Security::e($anc['content']) ?></div>
                        <div class="text-muted font-monospace" style="font-size:10px;"><?= Format::date($anc['created_at'], 'M d H:i') ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
