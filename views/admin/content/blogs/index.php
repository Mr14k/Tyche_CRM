<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Blog Content Marketing Engine</h2>
        <p class="text-secondary small m-0">Publish SEO articles, AEO/GEO insights, and educational guides</p>
    </div>
    <a href="<?= Url::to('/admin/content/blogs/create') ?>" class="btn btn-gold btn-sm px-3">
        <i class="bi bi-pencil-square"></i> Create Blog Article
    </a>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle m-0">
            <thead>
                <tr>
                    <th>Article Title & Slug</th>
                    <th>Category</th>
                    <th>Est. Read Time</th>
                    <th>Views</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($posts)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No blog articles created yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($posts as $p): ?>
                        <tr>
                            <td>
                                <div class="fw-semibold text-light"><?= Security::e($p['title']) ?></div>
                                <div class="font-monospace text-info small">/blog/<?= Security::e($p['slug']) ?></div>
                            </td>
                            <td><span class="badge bg-secondary font-monospace"><?= Security::e($p['category_name'] ?? 'General') ?></span></td>
                            <td class="font-monospace small text-warning"><i class="bi bi-clock"></i> <?= $p['reading_time_minutes'] ?> mins</td>
                            <td class="font-monospace small text-muted"><i class="bi bi-eye"></i> <?= number_format($p['views_count']) ?></td>
                            <td>
                                <?php if ($p['status'] === 'published'): ?>
                                    <span class="badge bg-success">Published</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= Url::to('/blog/' . $p['slug']) ?>" target="_blank" class="btn btn-outline-info btn-sm me-1" title="View Public Post"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
