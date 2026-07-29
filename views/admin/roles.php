<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Role & Permission Matrix</h2>
        <p class="text-secondary small m-0">Granular Database-driven Access Control Matrix</p>
    </div>
</div>

<form action="<?= Url::to('/admin/roles/matrix') ?>" method="POST">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
    
    <div class="card-custom p-4 mb-4">
        <div class="table-responsive">
            <table class="table table-custom table-bordered align-middle m-0">
                <thead>
                    <tr>
                        <th style="width:250px;">Permission Code / Module</th>
                        <?php foreach ($roles as $role): ?>
                            <th class="text-center font-monospace" style="min-width:140px;">
                                <?= Security::e($role['name']) ?>
                                <?php if ($role['is_system']): ?>
                                    <br><span class="badge bg-secondary" style="font-size:10px;">SYSTEM</span>
                                <?php endif; ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permissionsGrouped as $moduleName => $modulePerms): ?>
                        <tr class="table-dark">
                            <td colspan="<?= count($roles) + 1 ?>" class="font-monospace text-warning fw-bold py-2 bg-dark">
                                <i class="bi bi-folder2-open"></i> Module: <?= Security::e($moduleName) ?>
                            </td>
                        </tr>
                        <?php foreach ($modulePerms as $perm): ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold font-monospace text-light small"><?= Security::e($perm['code']) ?></div>
                                    <div class="text-muted" style="font-size:11px;"><?= Security::e($perm['display_name']) ?></div>
                                </td>
                                <?php foreach ($roles as $role): ?>
                                    <td class="text-center">
                                        <?php 
                                            $isChecked = in_array($perm['id'], $role['permissions'], true);
                                            $isSuperAdmin = ($role['name'] === 'Super Admin');
                                        ?>
                                        <div class="form-check d-flex justify-content-center m-0">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="matrix[<?= $role['id'] ?>][]" 
                                                   value="<?= $perm['id'] ?>"
                                                   <?= $isChecked ? 'checked' : '' ?>
                                                   <?= $isSuperAdmin ? 'disabled checked' : '' ?>>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-gold px-4 py-2 font-monospace"><i class="bi bi-save"></i> Save Matrix Definitions</button>
    </div>
</form>
