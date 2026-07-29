<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Centralized Media Library</h2>
        <p class="text-secondary small m-0">Organized into year/month storage structure (`storage/uploads/cms/YYYY/MM/`)</p>
    </div>
    <button class="btn btn-gold btn-sm px-3" data-bs-toggle="modal" data-bs-target="#uploadMediaModal">
        <i class="bi bi-cloud-upload-fill"></i> Upload New Media Asset
    </button>
</div>

<div class="card-custom p-4">
    <div class="row g-3">
        <?php if (empty($files)): ?>
            <div class="text-center text-muted py-5">No media files uploaded yet. Upload images, PDFs, or documents above.</div>
        <?php else: ?>
            <?php foreach ($files as $file): ?>
                <div class="col-md-3">
                    <div class="border border-secondary rounded p-3 text-center bg-dark h-100">
                        <?php if ($file['file_type'] === 'image'): ?>
                            <img src="<?= Url::upload($file['file_path']) ?>" class="img-fluid rounded mb-2" style="height:110px; object-fit:cover; width:100%;">
                        <?php else: ?>
                            <div class="py-4 text-warning"><i class="bi bi-file-earmark-text display-4"></i></div>
                        <?php endif; ?>
                        <div class="fw-semibold text-light small text-truncate" title="<?= Security::e($file['original_name']) ?>"><?= Security::e($file['original_name']) ?></div>
                        <div class="font-monospace text-muted" style="font-size:10px;"><?= number_format($file['file_size'] / 1024, 1) ?> KB • <?= Security::e($file['file_type']) ?></div>
                        <div class="mt-2">
                            <input type="text" class="form-control form-control-sm font-monospace text-center" value="<?= Url::upload($file['file_path']) ?>" readonly onclick="this.select();">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: Upload Media -->
<div class="modal fade" id="uploadMediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background:#161F2B; color:#F3EEE2; border:1px solid rgba(243,238,226,0.14);">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-monospace text-warning">Upload Media Asset</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= Url::to('/admin/cms/media/upload') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                    
                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Select Asset File (Images, PDF, Video)</label>
                        <input type="file" name="media_file" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Asset Category Folder</label>
                        <input type="text" name="folder" class="form-control" value="banners" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Tags (Comma Separated)</label>
                        <input type="text" name="tags" class="form-control" placeholder="hero, banner, logo">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold btn-sm">Upload & Save to YYYY/MM</button>
                </div>
            </form>
        </div>
    </div>
</div>
