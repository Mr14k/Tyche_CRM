<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Navigation Menu Manager</h2>
        <p class="text-secondary small m-0">Manage header, footer, and mobile navigation links</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-menu-app"></i> Header Navigation Links</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Link Title</th>
                            <th>Target URL</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($headerMenus as $hm): ?>
                            <tr>
                                <td class="font-monospace text-muted"><?= $hm['sort_order'] ?></td>
                                <td class="fw-semibold text-light"><?= Security::e($hm['title']) ?></td>
                                <td class="font-monospace text-info small"><?= Security::e($hm['url']) ?></td>
                                <td class="text-end">
                                    <form action="<?= Url::to('/admin/cms/menus/' . $hm['id'] . '/delete') ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-plus-circle"></i> Add Navigation Item</h5>
            <form action="<?= Url::to('/admin/cms/menus') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Menu Location</label>
                    <select name="location" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="header">Header Navigation</option>
                        <option value="footer">Footer Links</option>
                        <option value="mobile">Mobile Menu</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Link Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Courses" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Target URL / Path</label>
                    <input type="text" name="url" class="form-control font-monospace" placeholder="/page/about-us" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="0">
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4">Add Menu Link</button>
            </form>
        </div>
    </div>
</div>
