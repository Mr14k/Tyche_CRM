<?php
/** @var array $tenants */
/** @var array $plans */
/** @var array $tenantMetrics */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 font-weight-bold mb-1 text-white">SaaS Pilot Client Control Center</h1>
        <p class="text-slate-400 small mb-0" style="color: #94A3B8;">Provision, manage subscription tiers, control enabled modules, and monitor client business metrics</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm rounded-pill px-4" data-toggle="modal" data-target="#newTenantModal" data-bs-toggle="modal" data-bs-target="#newTenantModal">
        <i class="fas fa-plus mr-2"></i>Provision New Academy
    </button>
</div>

<?= \App\Helpers\Flash::render() ?>

<!-- Tier Matrix Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="background: #161F2B; border: 1px solid rgba(205,127,50,0.4) !important;">
            <div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #CD7F32; letter-spacing: 0.05em;">Bronze Tier</div>
                <div class="h5 mb-1 font-weight-bold text-white">100 Leads / mo</div>
                <small style="color: #94A3B8;">5 Courses • 100 Students • CRM & LMS</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="background: #161F2B; border: 1px solid rgba(168,168,168,0.4) !important;">
            <div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #CBD5E1; letter-spacing: 0.05em;">Silver Tier</div>
                <div class="h5 mb-1 font-weight-bold text-white">1,000 Leads / mo</div>
                <small style="color: #94A3B8;">25 Courses • 1,000 Students • BI & Finance</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="background: #161F2B; border: 1px solid rgba(212,175,55,0.4) !important;">
            <div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #D4AF37; letter-spacing: 0.05em;">Gold Tier</div>
                <div class="h5 mb-1 font-weight-bold text-white">10,000 Leads / mo</div>
                <small style="color: #94A3B8;">100 Courses • 10k Students • Placement & Auto</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="background: #161F2B; border: 1px solid rgba(59,130,246,0.4) !important;">
            <div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #60A5FA; letter-spacing: 0.05em;">Enterprise Tier</div>
                <div class="h5 mb-1 font-weight-bold text-white">Unlimited</div>
                <small style="color: #94A3B8;">Unlimited Everything • White-Labeling</small>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-lg overflow-hidden mb-4" style="background: #161F2B !important; border: 1px solid rgba(243,238,226,0.14) !important;">
    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background: #0F1620 !important; border-bottom: 1px solid rgba(243,238,226,0.14);">
        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-building text-warning mr-2"></i>Active Pilot Academies (<?= count($tenants) ?>)</h6>
        <span class="badge badge-warning px-3 py-1 font-weight-bold" style="background: #D9AE68 !important; color: #0F1620 !important;">Multi-Tenant SaaS</span>
    </div>
    <div class="card-body p-0" style="background: #161F2B !important;">
        <div class="table-responsive" style="background: #161F2B !important;">
            <table class="table table-hover align-middle mb-0" style="background: #161F2B !important; color: #F3EEE2 !important;">
                <thead style="background: #0F1620 !important; color: #D9AE68 !important; border-bottom: 1px solid rgba(243,238,226,0.14);">
                    <tr>
                        <th class="border-0 px-4 py-3 text-uppercase font-weight-bold" style="font-size: 12px; color: #D9AE68 !important; background: #0F1620 !important;">ID & Academy Name</th>
                        <th class="border-0 py-3 text-uppercase font-weight-bold" style="font-size: 12px; color: #D9AE68 !important; background: #0F1620 !important;">Subdomain</th>
                        <th class="border-0 py-3 text-uppercase font-weight-bold" style="font-size: 12px; color: #D9AE68 !important; background: #0F1620 !important;">Subscription Tier</th>
                        <th class="border-0 py-3 text-uppercase font-weight-bold" style="font-size: 12px; color: #D9AE68 !important; background: #0F1620 !important;">Usage & Metrics</th>
                        <th class="border-0 py-3 text-uppercase font-weight-bold" style="font-size: 12px; color: #D9AE68 !important; background: #0F1620 !important;">Status</th>
                        <th class="border-0 py-3 text-right pr-4 text-uppercase font-weight-bold" style="font-size: 12px; color: #D9AE68 !important; background: #0F1620 !important;">Control Actions</th>
                    </tr>
                </thead>
                <tbody style="background: #161F2B !important;">
                    <?php if (empty($tenants)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-slate-400" style="color: #CBD5E1 !important; background: #161F2B !important;">No pilot academies found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tenants as $t): ?>
                            <?php 
                                $metrics = $tenantMetrics[$t['id']] ?? [];
                                $activeModules = !empty($t['modules']) ? json_decode($t['modules'], true) : ['crm', 'lms'];
                                if (!is_array($activeModules)) $activeModules = ['crm', 'lms'];
                            ?>
                            <tr style="border-bottom: 1px solid rgba(243,238,226,0.08); background: #161F2B !important;">
                                <td class="px-4 py-3" style="background: #161F2B !important;">
                                    <div class="font-weight-bold text-white mb-0" style="font-size: 15px;">#<?= $t['id'] ?> — <?= \App\Helpers\Security::e($t['name']) ?></div>
                                    <small style="color: #CBD5E1 !important;"><i class="fas fa-envelope mr-1" style="color: #D9AE68;"></i><?= \App\Helpers\Security::e($t['email']) ?></small>
                                </td>
                                <td style="background: #161F2B !important;">
                                    <span class="badge px-3 py-1 font-monospace" style="background: rgba(59,130,246,0.2) !important; color: #60A5FA !important; border: 1px solid rgba(59,130,246,0.4) !important;">
                                        <?= \App\Helpers\Security::e($t['subdomain']) ?>.localhost
                                    </span>
                                </td>
                                <td style="background: #161F2B !important;">
                                    <form action="<?= \App\Helpers\Url::to('/admin/tenants/' . $t['id'] . '/plan') ?>" method="POST" class="d-inline-flex">
                                        <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                        <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                        <select name="plan_name" class="form-control form-control-sm rounded-pill font-weight-bold" onchange="this.form.submit()" style="background: #0F1620 !important; color: #F8FAFC !important; border: 1px solid rgba(243,238,226,0.2) !important;">
                                            <option value="Bronze" <?= $t['plan_name'] === 'Bronze' ? 'selected' : '' ?>>Bronze (100 Leads)</option>
                                            <option value="Silver" <?= $t['plan_name'] === 'Silver' ? 'selected' : '' ?>>Silver (1,000 Leads)</option>
                                            <option value="Gold" <?= $t['plan_name'] === 'Gold' ? 'selected' : '' ?>>Gold (10,000 Leads)</option>
                                            <option value="Enterprise" <?= $t['plan_name'] === 'Enterprise' ? 'selected' : '' ?>>Enterprise (Unlimited)</option>
                                        </select>
                                    </form>
                                </td>
                                <td style="background: #161F2B !important;">
                                    <div class="small mb-1 d-flex flex-wrap gap-1">
                                        <span class="badge px-2 py-1 mr-1" style="background: #0F1620 !important; color: #E2E8F0 !important; border: 1px solid rgba(243,238,226,0.15) !important;">
                                            Leads: <strong style="color: #60A5FA !important;"><?= $metrics['leads']['current'] ?? 0 ?> / <?= $metrics['leads']['max'] ?? '∞' ?></strong>
                                        </span>
                                        <span class="badge px-2 py-1 mr-1" style="background: #0F1620 !important; color: #E2E8F0 !important; border: 1px solid rgba(243,238,226,0.15) !important;">
                                            Courses: <strong style="color: #34D399 !important;"><?= $metrics['courses']['current'] ?? 0 ?> / <?= $metrics['courses']['max'] ?? '∞' ?></strong>
                                        </span>
                                        <span class="badge px-2 py-1" style="background: #0F1620 !important; color: #E2E8F0 !important; border: 1px solid rgba(243,238,226,0.15) !important;">
                                            Rev: <strong style="color: #F59E0B !important;">₹<?= number_format($metrics['total_revenue'] ?? 0) ?></strong>
                                        </span>
                                    </div>
                                    <div>
                                        <small style="color: #CBD5E1 !important;">Modules: </small>
                                        <?php foreach ($activeModules as $mod): ?>
                                            <span class="badge px-2 py-1 mr-1" style="font-size: 10px; background: rgba(217,174,104,0.2) !important; color: #F59E0B !important; border: 1px solid rgba(217,174,104,0.4) !important;"><?= strtoupper($mod) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td>
                                    <form action="<?= \App\Helpers\Url::to('/admin/tenants/' . $t['id'] . '/toggle-status') ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                        <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                        <?php if ($t['status'] === 'active'): ?>
                                            <button type="submit" class="btn btn-sm rounded-pill px-3 py-1 font-weight-bold" style="background: rgba(16,185,129,0.15); color: #34D399; border: 1px solid rgba(16,185,129,0.4);" onclick="return confirm('Suspend access for <?= \App\Helpers\Security::e($t['name']) ?>?')">
                                                <i class="fas fa-check-circle mr-1"></i>Active
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-sm rounded-pill px-3 py-1 font-weight-bold" style="background: rgba(239,68,68,0.15); color: #F87171; border: 1px solid rgba(239,68,68,0.4);" onclick="return confirm('Activate access for <?= \App\Helpers\Security::e($t['name']) ?>?')">
                                                <i class="fas fa-ban mr-1"></i>Suspended
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                                <td class="text-right pr-4">
                                    <button type="button" class="btn btn-sm rounded-pill mr-1 px-3" style="background: #0F1620; color: #D9AE68; border: 1px solid #D9AE68;" data-toggle="modal" data-target="#editTenantModal<?= $t['id'] ?>" data-bs-toggle="modal" data-bs-target="#editTenantModal<?= $t['id'] ?>">
                                        <i class="fas fa-edit mr-1"></i>Control & Modules
                                    </button>
                                    <a href="<?= \App\Helpers\Url::to('/dashboard?t=' . $t['subdomain']) ?>" target="_blank" class="btn btn-sm rounded-pill mr-1 px-3" style="background: rgba(59,130,246,0.15); color: #60A5FA; border: 1px solid #60A5FA;">
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
                                    <div class="modal-content text-white" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.2);">
                                        <div class="modal-header text-white" style="background: #0F1620; border-bottom: 1px solid rgba(243,238,226,0.14);">
                                            <h5 class="modal-title font-weight-bold" style="color: #D9AE68;">Super Admin Control: <?= \App\Helpers\Security::e($t['name']) ?> (#<?= $t['id'] ?>)</h5>
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
                                                        <label class="font-weight-bold" style="color: #D9AE68;">Academy Name</label>
                                                        <input type="text" name="name" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" value="<?= \App\Helpers\Security::e($t['name']) ?>" required>
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-bold" style="color: #D9AE68;">Admin Email</label>
                                                        <input type="email" name="email" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" value="<?= \App\Helpers\Security::e($t['email']) ?>" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-bold" style="color: #D9AE68;">Subscription Tier</label>
                                                        <select name="plan_name" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);">
                                                            <option value="Bronze" <?= $t['plan_name'] === 'Bronze' ? 'selected' : '' ?>>Bronze (100 Leads / 5 Courses)</option>
                                                            <option value="Silver" <?= $t['plan_name'] === 'Silver' ? 'selected' : '' ?>>Silver (1,000 Leads / 25 Courses)</option>
                                                            <option value="Gold" <?= $t['plan_name'] === 'Gold' ? 'selected' : '' ?>>Gold (10,000 Leads / 100 Courses)</option>
                                                            <option value="Enterprise" <?= $t['plan_name'] === 'Enterprise' ? 'selected' : '' ?>>Enterprise (Unlimited Everything)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-bold" style="color: #D9AE68;">Access Status</label>
                                                        <select name="status" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);">
                                                            <option value="active" <?= $t['status'] === 'active' ? 'selected' : '' ?>>Active Access</option>
                                                            <option value="suspended" <?= $t['status'] === 'suspended' ? 'selected' : '' ?>>Suspended Access</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr style="border-color: rgba(243,238,226,0.14);">
                                                <label class="font-weight-bold mb-2" style="color: #D9AE68;">Module Access Control (SaaS Super Admin Permissions)</label>
                                                <p style="color: #94A3B8;" class="small">Select which modules are accessible on this academy's dashboard sidebar:</p>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="modules[]" value="crm" id="mod_crm_<?= $t['id'] ?>" class="form-check-input" <?= in_array('crm', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="form-check-label font-weight-bold text-white" for="mod_crm_<?= $t['id'] ?>">Lead CRM & Sales</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="modules[]" value="lms" id="mod_lms_<?= $t['id'] ?>" class="form-check-input" <?= in_array('lms', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="form-check-label font-weight-bold text-white" for="mod_lms_<?= $t['id'] ?>">LMS & Courses</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="modules[]" value="bi" id="mod_bi_<?= $t['id'] ?>" class="form-check-input" <?= in_array('bi', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="form-check-label font-weight-bold text-white" for="mod_bi_<?= $t['id'] ?>">BI Telemetry & Reports</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="modules[]" value="finance" id="mod_fin_<?= $t['id'] ?>" class="form-check-input" <?= in_array('finance', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="form-check-label font-weight-bold text-white" for="mod_fin_<?= $t['id'] ?>">Finance & Invoices</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="modules[]" value="placement" id="mod_plc_<?= $t['id'] ?>" class="form-check-input" <?= in_array('placement', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="form-check-label font-weight-bold text-white" for="mod_plc_<?= $t['id'] ?>">Placement Cell</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="modules[]" value="automation" id="mod_aut_<?= $t['id'] ?>" class="form-check-input" <?= in_array('automation', $activeModules) ? 'checked' : '' ?>>
                                                            <label class="form-check-label font-weight-bold text-white" for="mod_aut_<?= $t['id'] ?>">Marketing Automation</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer px-4 py-3" style="background: #0F1620; border-top: 1px solid rgba(243,238,226,0.14);">
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
        <div class="modal-content text-white" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.2);">
            <div class="modal-header text-white" style="background: #0F1620; border-bottom: 1px solid rgba(243,238,226,0.14);">
                <h5 class="modal-title font-weight-bold" id="newTenantModalLabel" style="color: #D9AE68;">Provision New Pilot Client Academy</h5>
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
                            <label class="font-weight-bold" style="color: #D9AE68;">Academy Name</label>
                            <input type="text" name="name" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" placeholder="e.g. Apex Marketing Academy" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold" style="color: #D9AE68;">Subdomain Identifier</label>
                            <div class="input-group">
                                <input type="text" name="subdomain" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" placeholder="apex" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background: #0F1620; color: #CBD5E1; border: 1px solid rgba(243,238,226,0.2);">.localhost</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold" style="color: #D9AE68;">Client Admin Email</label>
                            <input type="email" name="admin_email" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" placeholder="admin@apexacademy.com" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold" style="color: #D9AE68;">Client Admin Password</label>
                            <input type="password" name="admin_password" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" placeholder="Create temporary password" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold" style="color: #D9AE68;">Subscription Tier & Limits</label>
                        <select name="plan_name" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);">
                            <option value="Bronze">Bronze Tier (100 Leads / 5 Courses / 100 Students)</option>
                            <option value="Silver">Silver Tier (1,000 Leads / 25 Courses / 1k Students)</option>
                            <option value="Gold">Gold Tier (10,000 Leads / 100 Courses / 10k Students)</option>
                            <option value="Enterprise">Enterprise Tier (Unlimited Everything + White-Label)</option>
                        </select>
                    </div>
                    <hr style="border-color: rgba(243,238,226,0.14);">
                    <label class="font-weight-bold mb-2" style="color: #D9AE68;">Granted Modules</label>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="crm" id="new_mod_crm" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_mod_crm">Lead CRM & Sales</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="lms" id="new_mod_lms" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_mod_lms">LMS & Courses</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="bi" id="new_mod_bi" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_mod_bi">BI Telemetry</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="finance" id="new_mod_fin" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_mod_fin">Finance & Invoices</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="placement" id="new_mod_plc" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_mod_plc">Placement Cell</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="automation" id="new_mod_aut" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_mod_aut">Marketing Automation</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="background: #0F1620; border-top: 1px solid rgba(243,238,226,0.14);">
                    <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Provision Academy</button>
                </div>
            </form>
        </div>
    </div>
</div>
