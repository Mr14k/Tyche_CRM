<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Edit Page: <?= Security::e($page['title']) ?></h2>
        <p class="text-secondary small m-0">Public URL: <a href="<?= Url::to('/page/' . $page['slug']) ?>" target="_blank" class="text-info">/page/<?= Security::e($page['slug']) ?></a></p>
    </div>
    <a href="<?= Url::to('/admin/cms/pages') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Pages</a>
</div>

<form action="<?= Url::to('/admin/cms/pages/' . $page['id']) ?>" method="POST">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card-custom p-4 mb-4">
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Page Title</label>
                    <input type="text" name="title" class="form-control" value="<?= Security::e($page['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">URL Slug</label>
                    <input type="text" name="slug" class="form-control font-monospace" value="<?= Security::e($page['slug']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">HTML Body Content</label>
                    <textarea name="content" class="form-control font-monospace" rows="12" required><?= Security::e($page['content']) ?></textarea>
                </div>
            </div>

            <!-- SEO Drawer -->
            <div class="card-custom p-4 mb-4">
                <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-search"></i> SEO & Search Engine Optimization</h5>
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="<?= Security::e($seo['meta_title'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2"><?= Security::e($seo['meta_description'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Keywords (Comma Separated)</label>
                    <input type="text" name="keywords" class="form-control" value="<?= Security::e($seo['keywords'] ?? '') ?>">
                </div>
            </div>

            <!-- Revision History Drawer (Capped to 10 Revisions) -->
            <div class="card-custom p-4">
                <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-clock-history"></i> Revision History Audit (Last 10 Revisions)</h5>
                <div class="table-responsive">
                    <table class="table table-custom table-hover align-middle m-0">
                        <thead>
                            <tr>
                                <th>Revision ID</th>
                                <th>Edited By</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($revisions)): ?>
                                <tr><td colspan="3" class="text-center text-muted py-2">No revisions logged.</td></tr>
                            <?php else: ?>
                                <?php foreach ($revisions as $rev): ?>
                                    <tr>
                                        <td class="font-monospace text-muted">#<?= $rev['id'] ?></td>
                                        <td class="small"><?= Security::e($rev['first_name'] . ' ' . $rev['last_name']) ?></td>
                                        <td class="small text-muted"><?= Format::date($rev['created_at'], 'M d, Y H:i:s') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-custom p-4 sticky-top" style="top:90px;">
                <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-sliders"></i> Publishing Settings</h5>
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Publishing Status</label>
                    <select name="status" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="published" <?= $page['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                        <option value="draft" <?= $page['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label text-warning font-monospace small">Layout Template</label>
                    <select name="template" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="default" <?= $page['template'] === 'default' ? 'selected' : '' ?>>Default Page Layout</option>
                        <option value="full-width" <?= $page['template'] === 'full-width' ? 'selected' : '' ?>>Full Width Layout</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-gold w-100 py-2 font-monospace"><i class="bi bi-save"></i> Update Page & Record Revision</button>
            </div>
        </div>
    </div>
</form>
