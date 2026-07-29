<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Database Backup & Recovery Utility</h2>
        <p class="text-secondary small m-0">Native PHP database SQL dump generator storing timestamped backups in storage/backups/</p>
    </div>
    <form action="<?= Url::to('/admin/system/backups/generate') ?>" method="POST" class="m-0">
        <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
        <button type="submit" class="btn btn-gold btn-sm px-3"><i class="bi bi-database-fill-down me-1"></i> Generate Instant Database Backup</button>
    </form>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle m-0">
            <thead>
                <tr>
                    <th>Backup Filename</th>
                    <th>Type</th>
                    <th>File Size</th>
                    <th>Created At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($backups)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No backup files generated yet. Click above to generate an instant SQL backup.</td></tr>
                <?php else: ?>
                    <?php foreach ($backups as $b): ?>
                        <tr>
                            <td class="fw-bold text-warning font-monospace"><?= Security::e($b['filename']) ?></td>
                            <td><span class="badge bg-info font-monospace"><?= strtoupper($b['backup_type']) ?></span></td>
                            <td class="font-monospace text-secondary"><?= round($b['file_size'] / 1024, 2) ?> KB</td>
                            <td class="small font-monospace text-muted"><?= Format::date($b['created_at'], 'M d, Y H:i:s') ?></td>
                            <td><span class="badge bg-success font-monospace">VERIFIED</span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
