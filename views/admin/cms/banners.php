<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Banners & Sliders Manager</h2>
        <p class="text-secondary small m-0">Configure promotional sliders and hero banners</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-images"></i> Active Banners</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Target URL</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($banners as $b): ?>
                            <tr>
                                <td class="fw-semibold text-light"><?= Security::e($b['title']) ?></td>
                                <td><span class="badge bg-info font-monospace"><?= Security::e($b['type']) ?></span></td>
                                <td class="font-monospace text-warning small"><?= Security::e($b['button_url'] ?? '—') ?></td>
                                <td><span class="badge bg-success">Active</span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-plus-circle"></i> Create Banner</h5>
            <form action="<?= Url::to('/admin/cms/banners') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Banner Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Banner Type</label>
                    <select name="type" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="hero">Homepage Hero Banner</option>
                        <option value="course">Course Banner</option>
                        <option value="popup">Promotional Popup</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Image Relative URL / Path</label>
                    <input type="text" name="image_url" class="form-control font-monospace" placeholder="assets/img/banner.jpg" required>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label text-warning font-monospace small">Button Text</label>
                        <input type="text" name="button_text" class="form-control" placeholder="Learn More">
                    </div>
                    <div class="col-6">
                        <label class="form-label text-warning font-monospace small">Button Link</label>
                        <input type="text" name="button_url" class="form-control" placeholder="/#join">
                    </div>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4">Create Banner Slider</button>
            </form>
        </div>
    </div>
</div>
