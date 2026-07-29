<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">CMS Pages Directory</h2>
        <p class="text-secondary small m-0">Create, manage, and edit website pages and dynamic content</p>
    </div>
    <a href="<?= Url::to('/admin/cms/pages/create') ?>" class="btn btn-gold btn-sm px-3">
        <i class="bi bi-file-earmark-plus"></i> Create New Page
    </a>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle m-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Page Title & URL</th>
                    <th>Template</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pages)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No CMS pages created yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($pages as $p): ?>
                        <tr>
                            <td class="font-monospace text-muted">#<?= $p['id'] ?></td>
                            <td>
                                <div class="fw-semibold text-light"><?= Security::e($p['title']) ?></div>
                                <div class="font-monospace text-info small">/page/<?= Security::e($p['slug']) ?></div>
                            </td>
                            <td><span class="badge bg-secondary font-monospace"><?= Security::e($p['template']) ?></span></td>
                            <td>
                                <?php if ($p['status'] === 'published'): ?>
                                    <span class="badge bg-success">Published</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted"><?= Format::date($p['updated_at'], 'M d, Y H:i') ?></td>
                            <td class="text-end">
                                <a href="<?= Url::to('/page/' . $p['slug']) ?>" target="_blank" class="btn btn-outline-info btn-sm me-1" title="View Public Page"><i class="bi bi-eye"></i></a>
                                <a href="<?= Url::to('/admin/cms/pages/' . $p['id'] . '/edit') ?>" class="btn btn-outline-warning btn-sm me-1" title="Edit Page"><i class="bi bi-pencil"></i></a>
                                <form action="<?= Url::to('/admin/cms/pages/' . $p['id'] . '/delete') ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Page"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
