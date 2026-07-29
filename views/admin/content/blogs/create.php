<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Create Blog Article</h2>
        <p class="text-secondary small m-0">Auto-saving draft active every 60 seconds <span id="autoSaveIndicator" class="badge bg-success ms-2 font-monospace">Ready</span></p>
    </div>
    <a href="<?= Url::to('/admin/content/blogs') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Blogs</a>
</div>

<form action="<?= Url::to('/admin/content/blogs') ?>" method="POST" id="blogArticleForm">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
    <input type="hidden" name="post_id" id="postIdInput" value="">

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card-custom p-4 mb-4">
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Article Title</label>
                    <input type="text" name="title" id="blogTitleInput" class="form-control" placeholder="e.g. Optimizing for AI Overviews in 2026" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">URL Slug</label>
                    <input type="text" name="slug" id="blogSlugInput" class="form-control font-monospace" placeholder="optimizing-for-ai-overviews" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Summary / Excerpt</label>
                    <textarea name="summary" class="form-control" rows="2" placeholder="Brief 2-sentence summary for post cards"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">HTML Body Content</label>
                    <textarea name="content" id="blogContentInput" class="form-control font-monospace" rows="14" placeholder="<h2>Introduction</h2><p>Article body...</p>" required></textarea>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-custom p-4 sticky-top" style="top:90px;">
                <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-sliders"></i> Article Settings</h5>
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Category</label>
                    <select name="category_id" id="blogCategoryInput" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= Security::e($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Status</label>
                    <select name="status" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="published">Publish Immediately</option>
                        <option value="draft">Save as Draft</option>
                    </select>
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featPostCheck">
                    <label class="form-check-label small text-light" for="featPostCheck">Featured Article</label>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="is_sticky" value="1" id="stickyPostCheck">
                    <label class="form-check-label small text-light" for="stickyPostCheck">Pin to Top of Blog</label>
                </div>

                <button type="submit" class="btn btn-gold w-100 py-2 font-monospace"><i class="bi bi-send"></i> Save & Publish Article</button>
            </div>
        </div>
    </div>
</form>

<script>
    const titleInput = document.getElementById('blogTitleInput');
    const slugInput = document.getElementById('blogSlugInput');
    const contentInput = document.getElementById('blogContentInput');
    const categoryInput = document.getElementById('blogCategoryInput');
    const postIdInput = document.getElementById('postIdInput');
    const autoSaveIndicator = document.getElementById('autoSaveIndicator');

    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            slugInput.value = this.value.toLowerCase().trim().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-');
        });
    }

    // Auto-Save Draft every 60 seconds
    setInterval(function() {
        const title = titleInput.value.trim();
        const content = contentInput.value.trim();
        if (!title && !content) return;

        autoSaveIndicator.className = 'badge bg-warning text-dark ms-2 font-monospace';
        autoSaveIndicator.innerText = 'Saving Draft...';

        const formData = new FormData();
        formData.append('_token', '<?= Security::csrfToken() ?>');
        formData.append('post_id', postIdInput.value);
        formData.append('title', title);
        formData.append('content', content);
        formData.append('category_id', categoryInput ? categoryInput.value : '');

        fetch('<?= Url::to('/admin/content/blogs/autosave') ?>', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.post_id) {
                postIdInput.value = data.post_id;
            }
            autoSaveIndicator.className = 'badge bg-success ms-2 font-monospace';
            autoSaveIndicator.innerText = 'Auto-saved at ' + data.saved_at;
        })
        .catch(err => {
            autoSaveIndicator.className = 'badge bg-danger ms-2 font-monospace';
            autoSaveIndicator.innerText = 'Auto-save failed';
        });
    }, 60000);
</script>
