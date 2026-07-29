<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Create CMS Page</h2>
        <p class="text-secondary small m-0">Build dynamic web page content with SEO controls</p>
    </div>
    <a href="<?= Url::to('/admin/cms/pages') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Pages</a>
</div>

<form action="<?= Url::to('/admin/cms/pages') ?>" method="POST">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card-custom p-4 mb-4">
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Page Title</label>
                    <input type="text" name="title" id="pageTitleInput" class="form-control" placeholder="e.g. About Our Academy" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">URL Slug</label>
                    <input type="text" name="slug" id="pageSlugInput" class="form-control font-monospace" placeholder="about-us" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">HTML Body Content</label>
                    <textarea name="content" class="form-control font-monospace" rows="12" placeholder="<h2>Page Heading</h2><p>Page body paragraph content...</p>" required></textarea>
                </div>
            </div>

            <!-- SEO Drawer -->
            <div class="card-custom p-4">
                <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-search"></i> SEO & Search Engine Optimization</h5>
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" placeholder="Custom Page Title for Search Engines">
                </div>
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2" placeholder="Brief summary of page content for search engines (150-160 chars)"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Keywords (Comma Separated)</label>
                    <input type="text" name="keywords" class="form-control" placeholder="digital marketing, academy, courses, seo">
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-custom p-4 sticky-top" style="top:90px;">
                <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-sliders"></i> Publishing Settings</h5>
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Publishing Status</label>
                    <select name="status" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label text-warning font-monospace small">Layout Template</label>
                    <select name="template" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="default">Default Page Layout</option>
                        <option value="full-width">Full Width Layout</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-gold w-100 py-2 font-monospace"><i class="bi bi-save"></i> Save Page</button>
            </div>
        </div>
    </div>
</form>

<script>
    // Auto-generate slug from title
    const titleInput = document.getElementById('pageTitleInput');
    const slugInput = document.getElementById('pageSlugInput');
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            slugInput.value = this.value.toLowerCase().trim().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-');
        });
    }
</script>
