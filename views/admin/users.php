<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">User Accounts & Identity Directory</h2>
        <p class="text-secondary small m-0">Provision staff, faculty, counselor, and student accounts with full RBAC role controls</p>
    </div>
    <button type="button" class="btn btn-gold btn-sm px-3 font-monospace" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="bi bi-person-plus-fill me-1"></i> Provision New Account
    </button>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom align-middle m-0" style="background:#161F2B !important; color:#F3EEE2 !important;">
            <thead>
                <tr>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">User Identity & Name</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Email Address</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Phone</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Assigned Roles</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Account Status</th>
                    <th style="background:#0F1620 !important; color:#D9AE68 !important;">Created At</th>
                    <th class="text-end" style="background:#0F1620 !important; color:#D9AE68 !important;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr style="background:#161F2B !important;">
                        <td style="background:#161F2B !important;">
                            <div class="fw-bold text-white fs-6"><?= Security::e($u['first_name'] . ' ' . $u['last_name']) ?></div>
                        </td>
                        <td style="background:#161F2B !important;" class="font-monospace text-info small"><?= Security::e($u['email']) ?></td>
                        <td style="background:#161F2B !important;" class="small text-light font-monospace"><?= Security::e($u['phone'] ?? '—') ?></td>
                        <td style="background:#161F2B !important;">
                            <?php foreach ($u['roles'] as $role): ?>
                                <span class="badge bg-warning text-dark font-monospace me-1"><?= Security::e($role['name']) ?></span>
                            <?php endforeach; ?>
                        </td>
                        <td style="background:#161F2B !important;">
                            <?php if ($u['status'] === 'active'): ?>
                                <span class="badge bg-success font-monospace">ACTIVE</span>
                            <?php else: ?>
                                <span class="badge bg-danger font-monospace"><?= strtoupper(Security::e($u['status'])) ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="background:#161F2B !important;" class="small font-monospace text-muted"><?= Format::date($u['created_at'], 'M d, Y') ?></td>
                        <td class="text-end" style="background:#161F2B !important;">
                            <!-- Edit Modal Trigger -->
                            <button type="button" class="btn btn-outline-warning btn-sm me-1 font-monospace" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $u['id'] ?>">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </button>

                            <!-- Toggle Status (Enable / Disable) -->
                            <form action="<?= Url::to('/admin/users/' . $u['id'] . '/toggle-status') ?>" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                <?php if ($u['status'] === 'active'): ?>
                                    <button type="submit" class="btn btn-outline-secondary btn-sm me-1 font-monospace" title="Disable Account"><i class="bi bi-slash-circle"></i> Disable</button>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-outline-success btn-sm me-1 font-monospace" title="Enable Account"><i class="bi bi-check-circle"></i> Enable</button>
                                <?php endif; ?>
                            </form>

                            <!-- Delete User -->
                            <form action="<?= Url::to('/admin/users/' . $u['id'] . '/delete') ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user account?');">
                                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete User"><i class="bi bi-trash"></i></button>
                            </form>

                            <!-- Edit Modal Window -->
                            <div class="modal fade text-start" id="editUserModal<?= $u['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-elevated text-light border">
                                        <div class="modal-header border-bottom border-line">
                                            <h5 class="modal-title font-monospace text-warning"><i class="bi bi-pencil-square me-1"></i> Edit User: <?= Security::e($u['first_name'] . ' ' . $u['last_name']) ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="<?= Url::to('/admin/users/' . $u['id']) ?>" method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                                
                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label text-warning font-monospace small">First Name *</label>
                                                        <input type="text" name="first_name" class="form-control font-monospace" value="<?= Security::e($u['first_name']) ?>" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label text-warning font-monospace small">Last Name *</label>
                                                        <input type="text" name="last_name" class="form-control font-monospace" value="<?= Security::e($u['last_name']) ?>" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-warning font-monospace small">Email Address *</label>
                                                    <input type="email" name="email" class="form-control font-monospace" value="<?= Security::e($u['email']) ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-warning font-monospace small">Phone Number *</label>
                                                    <input type="text" name="phone" class="form-control font-monospace" value="<?= Security::e($u['phone'] ?? '') ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-warning font-monospace small">Primary Role *</label>
                                                    <select name="role_id" class="form-select font-monospace" style="background:#0F1620; color:#F3EEE2;">
                                                        <?php 
                                                        $currentRoleId = !empty($u['roles'][0]['id']) ? (int)$u['roles'][0]['id'] : 4;
                                                        foreach ($roles as $role): 
                                                        ?>
                                                            <option value="<?= $role['id'] ?>" <?= $currentRoleId === (int)$role['id'] ? 'selected' : '' ?>>
                                                                <?= Security::e($role['display_name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-secondary font-monospace small">Reset Password (Leave blank to keep current)</label>
                                                    <input type="password" name="password" class="form-control font-monospace" minlength="8" placeholder="••••••••">
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top border-line">
                                                <button type="button" class="btn btn-outline-secondary btn-sm font-monospace text-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-gold btn-sm font-monospace fw-bold px-3">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Create User -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-elevated text-light border">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title font-monospace text-warning"><i class="bi bi-person-plus me-1"></i> Provision New Platform Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= Url::to('/admin/users') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label text-warning font-monospace small">First Name *</label>
                            <input type="text" name="first_name" class="form-control font-monospace" required placeholder="e.g. Rahul">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-warning font-monospace small">Last Name *</label>
                            <input type="text" name="last_name" class="form-control font-monospace" required placeholder="e.g. Sharma">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Email Address *</label>
                        <input type="email" name="email" class="form-control font-monospace" required placeholder="rahul@example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Phone Number *</label>
                        <input type="text" name="phone" class="form-control font-monospace" required placeholder="+91 98765 43210">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Primary Role *</label>
                        <select name="role_id" class="form-select font-monospace" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.25);" required>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= Security::e($role['display_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-warning font-monospace small">Initial Password *</label>
                        <input type="password" name="password" class="form-control font-monospace" required minlength="8" placeholder="••••••••">
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-outline-secondary btn-sm font-monospace text-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold btn-sm font-monospace fw-bold px-3">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
