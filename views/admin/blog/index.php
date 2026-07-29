<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Blog Engine & Article Publisher</h2>
        <p class="text-secondary small m-0">Publish SEO-optimized articles, case studies, AEO/GEO guides, and industry news</p>
    </div>
    <a href="<?= Url::to('/admin/blog/create') ?>" class="btn btn-gold btn-sm px-3 font-monospace">
        <i class="bi bi-pencil-square me-1"></i> Write New Article
    </a>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom align-middle m-0" style="background:#161F2B !important; color:#F3EEE2 !important;">
            <thead>
                <tr>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Article Title & Excerpt</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Category</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Author</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Status</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Views</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Published Date</th>
                    <th class="text-end" style="background:#0F1620 !important; color:#D9AE68 !important;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($posts)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">No blog articles published yet. Click 'Write New Article' to publish one.</td></tr>
                <?php else: ?>
                    <?php foreach ($posts as $p): ?>
                        <tr style="background:#161F2B !important;">
                            <td style="background:#161F2B !important; max-width: 320px;">
                                <?php if (!empty($p['is_featured'])): ?>
                                    <span class="badge bg-warning text-dark font-monospace mb-1"><i class="bi bi-star-fill me-1"></i> FEATURED</span>
                                <?php endif; ?>
                                <div class="fw-bold text-white fs-6"><?= Security::e($p['title']) ?></div>
                                <div class="text-muted small text-truncate"><?= Security::e($p['summary'] ?? '') ?></div>
                            </td>
                            <td style="background:#161F2B !important;"><span class="badge bg-secondary font-monospace"><?= Security::e($p['category_name'] ?? 'General') ?></span></td>
                            <td style="background:#161F2B !important; color:#F3EEE2 !important;" class="small font-monospace"><?= Security::e(($p['first_name'] ?? 'Admin') . ' ' . ($p['last_name'] ?? '')) ?></td>
                            <td style="background:#161F2B !important;">
                                <?php if ($p['status'] === 'published'): ?>
                                    <span class="badge bg-success font-monospace">PUBLISHED</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary font-monospace">DRAFT</span>
                                <?php endif; ?>
                            </td>
                            <td style="background:#161F2B !important;" class="font-monospace text-info small"><?= number_format((int)($p['views_count'] ?? 0)) ?> views</td>
                            <td style="background:#161F2B !important;" class="small font-monospace text-muted"><?= Format::date($p['published_at'] ?? $p['created_at'], 'M d, Y') ?></td>
                            <td class="text-end" style="background:#161F2B !important;">
                                <a href="<?= Url::to('/blog/' . $p['slug']) ?>" target="_blank" class="btn btn-outline-info btn-sm me-1" title="View Public Article"><i class="bi bi-eye"></i></a>
                                <a href="<?= Url::to('/admin/blog/' . $p['id'] . '/edit') ?>" class="btn btn-outline-warning btn-sm me-1" title="Edit Article"><i class="bi bi-pencil"></i> Edit</a>
                                <form action="<?= Url::to('/admin/blog/' . $p['id'] . '/delete') ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Article"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
