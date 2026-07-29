<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Build New Academic Course</h2>
        <p class="text-secondary small m-0">Set up course details, dynamic tier fees, and initial settings</p>
    </div>
    <a href="<?= Url::to('/admin/lms/courses') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Courses</a>
</div>

<div class="card-custom p-4 max-w-3xl" style="max-width:800px;">
    <form action="<?= Url::to('/admin/lms/courses') ?>" method="POST">
        <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

        <div class="row g-3 mb-3">
            <div class="col-8">
                <label class="form-label text-warning font-monospace small">Course Title *</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. Technical SEO, AEO & Programmatic Mastery" required>
            </div>
            <div class="col-4">
                <label class="form-label text-warning font-monospace small">Unique Course Code *</label>
                <input type="text" name="code" class="form-control font-monospace" placeholder="SEO-401" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-warning font-monospace small">Short Description / Subtitle</label>
            <input type="text" name="short_description" class="form-control" placeholder="Learn AEO, GEO AI search optimization, Google Ads, and DV360 programmatic buying.">
        </div>

        <div class="mb-3">
            <label class="form-label text-warning font-monospace small">Full Description & Syllabus Overview *</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Comprehensive 4-module blueprint taking students from SEO foundations to..." required></textarea>
        </div>

        <!-- Dynamic Tier Pricing Section -->
        <div class="p-3 bg-black bg-opacity-25 rounded border border-warning border-opacity-50 mb-3">
            <div class="fw-bold text-warning small font-monospace mb-2"><i class="bi bi-tags-fill me-1"></i> DYNAMIC COURSE TIER FEES (IN INR)</div>
            <div class="row g-2">
                <div class="col-4">
                    <label class="form-label text-warning font-monospace small">Self-Paced Track Fee (₹) *</label>
                    <input type="number" step="0.01" name="price" class="form-control font-monospace text-warning fw-bold" placeholder="8000.00" required>
                </div>
                <div class="col-4">
                    <label class="form-label text-warning font-monospace small">Live Cohort Tier Fee (₹)</label>
                    <input type="number" step="0.01" name="live_cohort_price" class="form-control font-monospace text-info fw-bold" placeholder="25000.00">
                </div>
                <div class="col-4">
                    <label class="form-label text-warning font-monospace small">Original Strike Fee (₹)</label>
                    <input type="number" step="0.01" name="discount_price" class="form-control font-monospace text-secondary" placeholder="15000.00">
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-4">
                <label class="form-label text-warning font-monospace small">Category *</label>
                <select name="category_id" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= Security::e($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label text-warning font-monospace small">Target Level</label>
                <select name="level" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                    <option value="all_levels">All Levels</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label text-warning font-monospace small">Est. Duration (Weeks)</label>
                <input type="number" name="duration_weeks" class="form-control" value="8">
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6">
                <label class="form-label text-warning font-monospace small">Initial Status</label>
                <select name="status" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                    <option value="draft">Draft (Private)</option>
                    <option value="published">Published (Public Catalog)</option>
                </select>
            </div>
            <div class="col-6 pt-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="allow_skip_lessons" value="1" id="skipCheck">
                    <label class="form-check-label small text-light" for="skipCheck">Allow Skip Lessons (Disable Sequential Locking)</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-gold btn-sm px-4 fw-bold">Create Course & Proceed to Modules →</button>
    </form>
</div>
