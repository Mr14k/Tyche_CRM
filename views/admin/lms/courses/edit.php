<?php
$highlights = !empty($course['highlights_json']) ? json_decode($course['highlights_json'], true) : [];
$tradPointsText = !empty($highlights['traditional_points']) ? implode("\n", $highlights['traditional_points']) : '';
$bluePointsText = !empty($highlights['blueprint_points']) ? implode("\n", $highlights['blueprint_points']) : '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Course Builder & Highlights: <?= Security::e($course['title']) ?></h2>
        <p class="text-secondary small m-0">Code: <span class="text-warning font-monospace"><?= Security::e($course['code']) ?></span> | Full Details, Fees & Custom Landing Highlights</p>
    </div>
    <a href="<?= Url::to('/admin/lms/courses') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Courses</a>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <!-- Full Course Details & Tier Pricing Editor Card -->
        <div class="card-custom p-4 mb-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-pencil-square"></i> Edit Course Details & Tier Fees</h5>
            <form action="<?= Url::to('/admin/lms/courses/' . $course['id'] . '/update') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="row g-2 mb-3">
                    <div class="col-8">
                        <label class="form-label text-warning font-monospace small">Course Title *</label>
                        <input type="text" name="title" class="form-control" value="<?= Security::e($course['title']) ?>" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-warning font-monospace small">Course Code *</label>
                        <input type="text" name="code" class="form-control font-monospace" value="<?= Security::e($course['code']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Short Description / Subtitle</label>
                    <input type="text" name="short_description" class="form-control" value="<?= Security::e($course['short_description'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Full Description</label>
                    <textarea name="description" class="form-control" rows="3" required><?= Security::e($course['description']) ?></textarea>
                </div>

                <!-- Dynamic Tier Pricing Section -->
                <div class="p-3 bg-black bg-opacity-25 rounded border border-warning border-opacity-50 mb-3">
                    <div class="fw-bold text-warning small font-monospace mb-2"><i class="bi bi-tags-fill me-1"></i> DYNAMIC TIER FEES (IN INR)</div>
                    <div class="row g-2">
                        <div class="col-4">
                            <label class="form-label text-warning font-monospace small">Self-Paced Tier Fee (₹) *</label>
                            <input type="number" step="0.01" name="price" class="form-control font-monospace text-warning fw-bold" value="<?= number_format((float)$course['price'], 2, '.', '') ?>" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-warning font-monospace small">Live Cohort Tier Fee (₹)</label>
                            <input type="number" step="0.01" name="live_cohort_price" class="form-control font-monospace text-info fw-bold" value="<?= number_format((float)($course['live_cohort_price'] ?? ($course['price'] * 3)), 2, '.', '') ?>">
                        </div>
                        <div class="col-4">
                            <label class="form-label text-warning font-monospace small">Strike-Through Fee (₹)</label>
                            <input type="number" step="0.01" name="discount_price" class="form-control font-monospace text-secondary" value="<?= !empty($course['discount_price']) ? number_format((float)$course['discount_price'], 2, '.', '') : '' ?>" placeholder="e.g. 15000">
                        </div>
                    </div>
                </div>

                <!-- Course-Specific Comparison & Pain Points Section -->
                <div class="p-3 bg-black bg-opacity-25 rounded border border-info border-opacity-50 mb-3">
                    <div class="fw-bold text-info small font-monospace mb-2"><i class="bi bi-card-checklist me-1"></i> COURSE LANDING COMPARISON & HIGHLIGHTS</div>
                    
                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Section Main Heading</label>
                        <input type="text" name="highlights_section_title" class="form-control" value="<?= Security::e($highlights['section_title'] ?? 'Why Traditional Marketing Courses Fail in 2026') ?>">
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label text-danger small fw-bold">Traditional / Competitor Title</label>
                            <input type="text" name="traditional_title" class="form-control mb-2" value="<?= Security::e($highlights['traditional_title'] ?? 'Traditional Coaching Institutes') ?>">
                            
                            <label class="form-label text-warning font-monospace small">Drawbacks / Limitations (1 per line)</label>
                            <textarea name="traditional_points" class="form-control font-monospace small" rows="5" placeholder="Ignore AI Search (Google AI Overviews, ChatGPT).&#10;Skip DV360 & Programmatic Advertising.&#10;Teach generic dummy websites."><?= Security::e($tradPointsText) ?></textarea>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-success small fw-bold">Tyche Course Solution Title</label>
                            <input type="text" name="blueprint_title" class="form-control mb-2" value="<?= Security::e($highlights['blueprint_title'] ?? 'The Tyche Executive Blueprint') ?>">
                            
                            <label class="form-label text-warning font-monospace small">Course Highlights & Solutions (1 per line)</label>
                            <textarea name="blueprint_points" class="form-control font-monospace small" rows="5" placeholder="AEO & GEO Mastery: Optimizing content for LLM crawlers.&#10;DV360 Programmatic: First-party data & DSP/SSP.&#10;BOS Center Case Studies: Real client campaign metrics."><?= Security::e($bluePointsText) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <label class="form-label text-warning font-monospace small">Category</label>
                        <select name="category_id" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $course['category_id'] ? 'selected' : '' ?>><?= Security::e($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-warning font-monospace small">Status</label>
                        <select name="status" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                            <option value="draft" <?= $course['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="published" <?= $course['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                            <option value="archived" <?= $course['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-warning font-monospace small">Duration (Weeks)</label>
                        <input type="number" name="duration_weeks" class="form-control" value="<?= (int)$course['duration_weeks'] ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="allow_skip_lessons" value="1" id="skipCheck" <?= !empty($course['allow_skip_lessons']) ? 'checked' : '' ?>>
                        <label class="form-check-label small text-light" for="skipCheck">Allow Skip Lessons (Disable Sequential Locking)</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4 fw-bold"><i class="bi bi-save-fill me-1"></i> Update Course Details, Fees & Highlights</button>
            </form>
        </div>

        <!-- Academic Hierarchy Tree -->
        <div class="card-custom p-4 mb-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-diagram-3"></i> Academic Hierarchy Tree</h5>
            
            <?php if (empty($hierarchy)): ?>
                <div class="text-center text-muted py-4">No modules added yet. Add a module on the right panel to begin.</div>
            <?php else: ?>
                <div class="accordion" id="moduleAccordion">
                    <?php foreach ($hierarchy as $mIdx => $mod): ?>
                        <div class="accordion-item bg-dark border-secondary mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-dark text-light border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modCollapse<?= $mod['id'] ?>">
                                    <i class="bi bi-folder-fill me-2 text-warning"></i> Module <?= $mIdx + 1 ?>: <?= Security::e($mod['title']) ?>
                                </button>
                            </h2>
                            <div id="modCollapse<?= $mod['id'] ?>" class="accordion-collapse collapse p-3">
                                <p class="text-secondary small"><?= Security::e($mod['description'] ?? '') ?></p>
                                
                                <?php if (empty($mod['chapters'])): ?>
                                    <div class="text-muted small ps-3">No chapters in this module.</div>
                                <?php else: ?>
                                    <?php foreach ($mod['chapters'] as $cIdx => $chap): ?>
                                        <div class="border-start border-warning ps-3 mb-3">
                                            <div class="fw-semibold text-info small"><i class="bi bi-bookmark"></i> Chapter <?= $cIdx + 1 ?>: <?= Security::e($chap['title']) ?></div>
                                            
                                            <ul class="list-unstyled mt-2">
                                                <?php foreach ($chap['lessons'] as $les): ?>
                                                    <li class="d-flex justify-content-between align-items-center bg-black bg-opacity-25 p-2 rounded mb-1 border border-secondary">
                                                        <div>
                                                            <i class="bi bi-play-circle-fill text-danger me-2"></i>
                                                            <span class="small text-light fw-semibold"><?= Security::e($les['title']) ?></span>
                                                            <span class="font-monospace text-muted ms-2" style="font-size:11px;"><?= $les['duration_minutes'] ?> mins</span>
                                                            <?php if ($les['is_preview']): ?>
                                                                <span class="badge bg-success ms-2 font-monospace" style="font-size:9px;">Preview</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <a href="<?= Url::to('/courses/' . $course['slug'] . '/learn/' . $les['id']) ?>" target="_blank" class="btn btn-outline-warning btn-sm py-0 px-2" style="font-size:10px;"><i class="bi bi-play"></i> Test Player</a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-5">
        <!-- 1. Add Module Form -->
        <div class="card-custom p-4 mb-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-folder-plus"></i> 1. Add Course Module</h5>
            <form action="<?= Url::to('/admin/lms/courses/' . $course['id'] . '/modules') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Module Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Module I: Technical SEO Architecture" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Description</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-gold btn-sm px-4">Add Module</button>
            </form>
        </div>

        <!-- 2. Add Chapter Form -->
        <div class="card-custom p-4 mb-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-bookmark-plus"></i> 2. Add Chapter to Module</h5>
            <form action="<?= Url::to('/admin/lms/courses/' . $course['id'] . '/chapters') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Select Target Module</label>
                    <select name="module_id" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);" required>
                        <?php foreach ($hierarchy as $m): ?>
                            <option value="<?= $m['id'] ?>"><?= Security::e($m['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Chapter Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Chapter 1: Search Bot Indexing" required>
                </div>
                <button type="submit" class="btn btn-gold btn-sm px-4">Add Chapter</button>
            </form>
        </div>

        <!-- 3. Add Video Lesson Form -->
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-camera-video"></i> 3. Add Video Lesson</h5>
            <form action="<?= Url::to('/admin/lms/courses/' . $course['id'] . '/lessons') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Select Target Chapter</label>
                    <select name="chapter_id" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);" required>
                        <?php foreach ($hierarchy as $m): ?>
                            <?php foreach ($m['chapters'] as $ch): ?>
                                <option value="<?= $ch['id'] ?>"><?= Security::e($m['title']) ?> → <?= Security::e($ch['title']) ?></option>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Lesson Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Lesson 1.1: Crawl Budgets & robots.txt" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Secure Video Embed Stream URL</label>
                    <input type="text" name="video_url" class="form-control font-monospace" placeholder="https://www.youtube.com/embed/dQw4w9WgXcQ" required>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label text-warning font-monospace small">Est. Duration (Mins)</label>
                        <input type="number" name="duration_minutes" class="form-control" value="15">
                    </div>
                    <div class="col-6 pt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_preview" value="1" id="prevCheck">
                            <label class="form-check-label small text-light" for="prevCheck">Free Demo Preview</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4">Add Lesson Video</button>
            </form>
        </div>
    </div>
</div>
