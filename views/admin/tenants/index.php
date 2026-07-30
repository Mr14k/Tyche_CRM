<?php
/** @var array $tenants */
/** @var array $plans */
/** @var array $tenantMetrics */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-gray-800 font-weight-bold mb-1">SaaS Pilot Client Control Center</h1>
        <p class="text-muted small mb-0">Provision, manage subscription tiers, control enabled modules, and monitor client business metrics</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm rounded-pill px-4" data-toggle="modal" data-target="#newTenantModal" data-bs-toggle="modal" data-bs-target="#newTenantModal">
        <i class="fas fa-plus mr-2"></i>Provision New Academy
    </button>
</div>

<?= \App\Helpers\Flash::render() ?>

<!-- Tier Matrix Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-bronze">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #cd7f32;">Bronze Tier</div>
                <div class="h5 mb-0 font-weight-bold">100 Leads / mo</div>
                <small class="text-muted">5 Courses • 100 Students • CRM & LMS</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-silver">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #a8a8a8;">Silver Tier</div>
                <div class="h5 mb-0 font-weight-bold">1,000 Leads / mo</div>
                <small class="text-muted">25 Courses • 1,000 Students • BI & Finance</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-gold">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #d4af37;">Gold Tier</div>
                <div class="h5 mb-0 font-weight-bold">10,000 Leads / mo</div>
                <small class="text-muted">100 Courses • 10k Students • Placement & Auto</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-left-primary">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Enterprise Tier</div>
                <div class="h5 mb-0 font-weight-bold text-primary">Unlimited</div>
                <small class="text-muted">Unlimited Everything • White-Labeling</small>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-lg overflow-hidden mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Active Pilot Academies (<?= count($tenants) ?>)</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="border-0 px-4 py-3">ID & Academy</th>
                        <th class="border-0 py-3">Subdomain</th>
                        <th class="border-0 py-3">Subscription Tier</th>
                        <th class="border-0 py-3">Usage & Metrics</th>
                        <th class="border-0 py-3">Status</th>
                        <th class="border-0 py-3 text-right pr-4">Control Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tenants)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No pilot academies found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tenants as $t): ?>
                            <?php 
                                $metrics = $tenantMetrics[$t['id']] ?? [];
                                $activeModules = !empty($t['modules']) ? json_decode($t['modules'], true) : ['crm', 'lms'];
                                if (!is_array($activeModules)) $activeModules = ['crm', 'lms'];
                            ?>
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-weight-bold text-dark mb-0">#<?= $t['id'] ?> — <?= \App\Helpers\Security::e($t['name']) ?></div>
                                    <small class="text-muted"><i class="fas fa-envelope mr-1"></i><?= \App\Helpers\Security::e($t['email']) ?></small>
                                </td>
                                <td>
                                    <span class="badge badge-soft-primary px-3 py-1 font-monospace">
                                        <?= \App\Helpers\Security::e($t['subdomain']) ?>.localhost
                                    </span>
                                </td>
                                <td>
                                    <form action="<?= \App\Helpers\Url::to('/admin/tenants/' . $t['id'] . '/plan') ?>" method="POST" class="d-inline-flex">
                                        <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                        <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                        <select name="plan_name" class="form-control form-control-sm rounded-pill" onchange="this.form.submit()">
                                            <option value="Bronze" <?= $t['plan_name'] === 'Bronze' ? 'selected' : '' ?>>Bronze (100 Leads)</option>
                                            <option value="Silver" <?= $t['plan_name'] === 'Silver' ? 'selected' : '' ?>>Silver (1,000 Leads)</option>
                                            <option value="Gold" <?= $t['plan_name'] === 'Gold' ? 'selected' : '' ?>>Gold (10,000 Leads)</option>
                                            <option value="Enterprise" <?= $t['plan_name'] === 'Enterprise' ? 'selected' : '' ?>>Enterprise (Unlimited)</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <div class="small">
                                        <span class="badge badge-light border text-dark mr-1">
                                            Leads: <strong><?= $metrics['leads']['current'] ?? 0 ?> / <?= $metrics['leads']['max'] ?? '∞' ?></strong>
                                        </span>
                                        <span class="badge badge-light border text-dark mr-1">
                                            Courses: <strong><?= $metrics['courses']['current'] ?? 0 ?> / <?= $metrics['courses']['max'] ?? '∞' ?></strong>
                                        </span>
                                        <span class="badge badge-light border text-dark">
                                            Rev: <strong>₹<?= number_format($metrics['total_revenue'] ?? 0) ?></strong>
                                        </span>
                                    </div>
                                    <div class="mt-1">
                                        <small class="text-muted">Modules: </small>
                                        <?php foreach ($activeModules as $mod): ?>
                                            <span class="badge badge-info px-1 py-0" style="font-size: 10px;"><?= strtoupper($mod) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td>
                                    <form action="<?= \App\Helpers\Url::to('/admin/tenants/' . $t['id'] . '/toggle-status') ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                        <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                        <?php if ($t['status'] === 'active'): ?>
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 py-1" onclick="return confirm('Suspend access for <?= \App\Helpers\Security::e($t['name']) ?>?')">
                                                <i class="fas fa-check-circle mr-1"></i>Active
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 py-1" onclick="return confirm('Activate access for <?= \App\Helpers\Security::e($t['name']) ?>?')">
                                                <i class="fas fa-ban mr-1"></i>Suspended
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                                <td class="text-right pr-4">
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill mr-1" data-toggle="modal" data-target="#editTenantModal<?= $t['id'] ?>" data-bs-toggle="modal" data-bs-target="#editTenantModal<?= $t['id'] ?>">
                                        <i class="fas fa-edit mr-1"></i>Control & Modules
                                    </button>
                                    <a href="<?= \App\Helpers\Url::to('/dashboard?t=' . $t['subdomain']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill mr-1">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <?php if ($t['id'] != 1): ?>
                                        <form action="<?= \App\Helpers\Url::to('/admin/tenants/' . $t['id'] . '/delete') ?>" method="POST" class="d-inline">
                                            <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" onclick="return confirm('Are you sure you want to delete tenant <?= \App\Helpers\Security::e($t['name']) ?>?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Edit Tenant Control Modal -->
                            <div class="modal fade" id="editTenantModal<?= $t['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title font-weight-bold">Super Admin Control: <?= \App\Helpers\Security::e($t['name']) ?> (#<?= $t['id'] ?>)</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?= \App\Helpers\Url::to('/admin/tenants/' . $t['id']) ?>" method="POST">
                                            <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                            <div class="modal-body p-4">
                                                <div class="row">
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-bold text-dark">Academy Name</label>
                                                        <input type="text" name="name" class="form-control" value="<?= \App\Helpers\Security::e($t['name']) ?>" required>
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-bold text-dark">Admin Email</label>
                                                        <input type="email" name="email" class="form-control" value="<?= \App\Helpers\Security::e($t['email']) ?>" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-bold text-dark">Subscription Tier</label>
                                                        <select name="plan_name" class="form-control">
                                                            <option value="Bronze" <?= $t['plan_name'] === 'Bronze' ? 'selected' : '' ?>>Bronze (100 Leads / 5 Courses)</option>
                                                            <option value="Silver" <?= $t['plan_name'] === 'Silver' ? 'selected' : '' ?>>Silver (1,000 Leads / 25 Courses)</option>
                                                            <option value="Gold" <?= $t['plan_name'] === 'Gold' ? 'selected' : '' ?>>Gold (10,000 Leads / 100 Courses)</option>
                                                            <option value="Enterprise" <?= $t['plan_name'] === 'Enterprise' ? 'selected' : '' ?>>Enterprise (Unlimited Everything)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-bold text-dark">Access Status</label>
                                                        <select name="status" class="form-control">
                                                            <option value="active" <?= $t['status'] === 'active' ? 'selected' : '' ?>>Active Access</option>
                                                            <option value="suspended" <?= $t['status'] === 'suspended' ? 'selected' : '' ?>>Suspended Access</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <label class="font-weight-bold text-dark mb-2">Module Access Control (SaaS Super Admin Permissions)</label>
                                                <p class="text-muted small">Select which modules are accessible on this academy's dashboard sidebar:</p>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="modules[]" value="crm" id="mod_crm_<?= $t['id'] ?>" class="custom-control-input" <?= in_array('crm', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="custom-control-label font-weight-bold" for="mod_crm_<?= $t['id'] ?>">Lead CRM & Sales</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="modules[]" value="lms" id="mod_lms_<?= $t['id'] ?>" class="custom-control-input" <?= in_array('lms', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="custom-control-label font-weight-bold" for="mod_lms_<?= $t['id'] ?>">LMS & Courses</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="modules[]" value="bi" id="mod_bi_<?= $t['id'] ?>" class="custom-control-input" <?= in_array('bi', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="custom-control-label font-weight-bold" for="mod_bi_<?= $t['id'] ?>">BI Telemetry & Reports</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="modules[]" value="finance" id="mod_fin_<?= $t['id'] ?>" class="custom-control-input" <?= in_array('finance', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="custom-control-label font-weight-bold" for="mod_fin_<?= $t['id'] ?>">Finance & Invoices</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="modules[]" value="placement" id="mod_plc_<?= $t['id'] ?>" class="custom-control-input" <?= in_array('placement', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="custom-control-label font-weight-bold" for="mod_plc_<?= $t['id'] ?>">Placement Cell</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="modules[]" value="automation" id="mod_aut_<?= $t['id'] ?>" class="custom-control-input" <?= in_array('automation', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="custom-control-label font-weight-bold" for="mod_aut_<?= $t['id'] ?>">Marketing Automation</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light px-4 py-3">
                                                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Provision New Tenant Modal -->
<div class="modal fade" id="newTenantModal" tabindex="-1" role="dialog" aria-labelledby="newTenantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold" id="newTenantModalLabel">Provision New Pilot Client Academy</h5>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= \App\Helpers\Url::to('/admin/tenants') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">Academy Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Apex Marketing Academy" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">Subdomain Identifier</label>
                            <div class="input-group">
                                <input type="text" name="subdomain" class="form-control" placeholder="apex" required>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-light">.localhost</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">Client Admin Email</label>
                            <input type="email" name="admin_email" class="form-control" placeholder="admin@apexacademy.com" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">Client Admin Password</label>
                            <input type="password" name="admin_password" class="form-control" placeholder="Create temporary password" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Subscription Tier & Limits</label>
                        <select name="plan_name" class="form-control">
                            <option value="Bronze">Bronze Tier (100 Leads / 5 Courses / 100 Students)</option>
                            <option value="Silver">Silver Tier (1,000 Leads / 25 Courses / 1k Students)</option>
                            <option value="Gold">Gold Tier (10,000 Leads / 100 Courses / 10k Students)</option>
                            <option value="Enterprise">Enterprise Tier (Unlimited Everything + White-Label)</option>
                        </select>
                    </div>
                    <hr>
                    <label class="font-weight-bold text-dark mb-2">Granted Modules</label>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="modules[]" value="crm" id="new_mod_crm" class="custom-control-input" checked>
                                <label class="custom-control-label" for="new_mod_crm">Lead CRM & Sales</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="modules[]" value="lms" id="new_mod_lms" class="custom-control-input" checked>
                                <label class="custom-control-label" for="new_mod_lms">LMS & Courses</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="modules[]" value="bi" id="new_mod_bi" class="custom-control-input" checked>
                                <label class="custom-control-label" for="new_mod_bi">BI Telemetry</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="modules[]" value="finance" id="new_mod_fin" class="custom-control-input" checked>
                                <label class="custom-control-label" for="new_mod_fin">Finance & Invoices</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="modules[]" value="placement" id="new_mod_plc" class="custom-control-input" checked>
                                <label class="custom-control-label" for="new_mod_plc">Placement Cell</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="modules[]" value="automation" id="new_mod_aut" class="custom-control-input" checked>
                                <label class="custom-control-label" for="new_mod_aut">Marketing Automation</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Provision Academy</button>
                </div>
            </form>
        </div>
    </div>
</div>
