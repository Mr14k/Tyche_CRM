<?php
/** @var array $tenants */
/** @var array $plans */
/** @var int $totalTenants */
/** @var int $activeTenants */
/** @var float $mrr */
/** @var array $tenantStats */
/** @var array $expiringTenants */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 font-weight-bold mb-1 text-white">SaaS Subscription & Tier Manager</h1>
        <p class="text-slate-400 small mb-0" style="color: #94A3B8;">Configure subscription tiers, manage module permissions, track MRR, and monitor tenant capacity limits</p>
    </div>
    <button type="button" class="btn btn-warning shadow-sm rounded-pill px-4 font-weight-bold" style="background: #D9AE68; color: #0F1620; border: none;" data-toggle="modal" data-target="#newPlanModal" data-bs-toggle="modal" data-bs-target="#newPlanModal">
        <i class="fas fa-plus-circle mr-2"></i>Create New Subscription Tier
    </button>
</div>

<?= \App\Helpers\Flash::render() ?>

<!-- Executive SaaS KPIs -->
<div class="row mb-4">
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.14) !important;">
            <div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #94A3B8;">Total Onboarded Academies</div>
                <div class="h3 mb-0 font-weight-bold text-white"><?= $totalTenants ?></div>
                <small style="color: #34D399;"><i class="fas fa-check-circle mr-1"></i><?= $activeTenants ?> Active Accounts</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="background: #161F2B; border: 1px solid rgba(217,174,104,0.3) !important;">
            <div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #D9AE68;">Estimated MRR</div>
                <div class="h3 mb-0 font-weight-bold text-warning" style="color: #F59E0B !important;">₹<?= number_format($mrr) ?></div>
                <small style="color: #94A3B8;">Monthly Subscription Revenue</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="background: #161F2B; border: 1px solid rgba(59,130,246,0.3) !important;">
            <div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #60A5FA;">Expiring Subscriptions</div>
                <div class="h3 mb-0 font-weight-bold text-info" style="color: #60A5FA !important;"><?= count($expiringTenants) ?></div>
                <small style="color: #94A3B8;">Renewals due in ≤ 14 days</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="background: #161F2B; border: 1px solid rgba(16,185,129,0.3) !important;">
            <div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #34D399;">System Capacity Index</div>
                <div class="h3 mb-0 font-weight-bold text-success" style="color: #34D399 !important;">100% Healthy</div>
                <small style="color: #94A3B8;">Multi-Tenant Isolation Active</small>
            </div>
        </div>
    </div>
</div>

<!-- Active Subscription Tiers Configurator -->
<div class="card border-0 shadow-sm rounded-lg overflow-hidden mb-4" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.14) !important;">
    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background: #0F1620; border-bottom: 1px solid rgba(243,238,226,0.14);">
        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-layer-group text-warning mr-2"></i>Active Subscription Tiers & Module Control</h6>
        <span class="badge badge-warning px-3 py-1 font-weight-bold" style="background: #D9AE68; color: #0F1620;"><?= count($plans) ?> Tiers Active</span>
    </div>
    <div class="card-body p-4">
        <div class="row">
            <?php foreach ($plans as $key => $p): ?>
                <?php 
                    $modules = $p['modules'] ?? [];
                    if (!is_array($modules)) $modules = ['crm', 'lms'];
                ?>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.15) !important;">
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="font-weight-bold mb-0 text-white"><?= \App\Helpers\Security::e($p['name']) ?></h6>
                                    <span class="badge px-2 py-1 font-monospace" style="background: rgba(217,174,104,0.15); color: #D9AE68; border: 1px solid rgba(217,174,104,0.3);"><?= \App\Helpers\Security::e($key) ?></span>
                                </div>
                                <div class="h4 font-weight-bold text-warning mb-2" style="color: #F59E0B !important;">₹<?= number_format($p['price']) ?><small style="font-size:12px; color:#94A3B8;">/mo</small></div>
                                <ul class="list-unstyled small mb-3" style="color: #CBD5E1;">
                                    <li class="mb-1"><i class="fas fa-check text-success mr-2"></i>Leads: <strong><?= $p['max_leads'] === -1 ? 'Unlimited' : number_format($p['max_leads']) ?></strong></li>
                                    <li class="mb-1"><i class="fas fa-check text-success mr-2"></i>Courses: <strong><?= $p['max_courses'] === -1 ? 'Unlimited' : number_format($p['max_courses']) ?></strong></li>
                                    <li class="mb-1"><i class="fas fa-check text-success mr-2"></i>Students: <strong><?= $p['max_students'] === -1 ? 'Unlimited' : number_format($p['max_students']) ?></strong></li>
                                </ul>
                                <div class="mb-3">
                                    <small style="color: #94A3B8;" class="d-block mb-1 font-weight-bold">Included Modules:</small>
                                    <?php foreach ($modules as $mod): ?>
                                        <span class="badge px-2 py-0 mr-1 mb-1" style="font-size: 10px; background: rgba(59,130,246,0.15); color: #60A5FA; border: 1px solid rgba(59,130,246,0.3);"><?= strtoupper($mod) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-warning rounded-pill w-100 mt-2 font-weight-bold" data-toggle="modal" data-target="#editPlanModal<?= $p['id'] ?? $key ?>" data-bs-toggle="modal" data-bs-target="#editPlanModal<?= $p['id'] ?? $key ?>">
                                <i class="fas fa-edit mr-1"></i>Configure Tier & Limits
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Edit Subscription Tier Modal -->
                <div class="modal fade" id="editPlanModal<?= $p['id'] ?? $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content text-white" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.2);">
                            <div class="modal-header text-white" style="background: #0F1620; border-bottom: 1px solid rgba(243,238,226,0.14);">
                                <h5 class="modal-title font-weight-bold" style="color: #D9AE68;">Configure Subscription Tier: <?= \App\Helpers\Security::e($p['name']) ?></h5>
                                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= \App\Helpers\Url::to('/admin/subscriptions/plans/' . ($p['id'] ?? 1)) ?>" method="POST">
                                <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                <div class="modal-body p-4">
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold" style="color: #D9AE68;">Tier Display Name</label>
                                            <input type="text" name="name" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" value="<?= \App\Helpers\Security::e($p['name']) ?>" required>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold" style="color: #D9AE68;">Monthly Price (₹)</label>
                                            <input type="number" step="0.01" name="price" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" value="<?= $p['price'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="font-weight-bold" style="color: #D9AE68;">Max Leads / mo (-1 = Unlimited)</label>
                                            <input type="number" name="max_leads" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" value="<?= $p['max_leads'] ?>" required>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="font-weight-bold" style="color: #D9AE68;">Max Courses (-1 = Unlimited)</label>
                                            <input type="number" name="max_courses" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" value="<?= $p['max_courses'] ?>" required>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="font-weight-bold" style="color: #D9AE68;">Max Students (-1 = Unlimited)</label>
                                            <input type="number" name="max_students" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" value="<?= $p['max_students'] ?>" required>
                                        </div>
                                    </div>
                                    <hr style="border-color: rgba(243,238,226,0.14);">
                                    <label class="font-weight-bold mb-2" style="color: #D9AE68;">Default Included Modules for this Tier</label>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="modules[]" value="crm" id="plan_crm_<?= $key ?>" class="form-check-input" <?= in_array('crm', $modules) ? 'checked' : '' ?>>
                                                <label class="form-check-label text-white" for="plan_crm_<?= $key ?>">Lead CRM & Sales</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="modules[]" value="lms" id="plan_lms_<?= $key ?>" class="form-check-input" <?= in_array('lms', $modules) ? 'checked' : '' ?>>
                                                <label class="form-check-label text-white" for="plan_lms_<?= $key ?>">LMS & Courses</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="modules[]" value="bi" id="plan_bi_<?= $key ?>" class="form-check-input" <?= in_array('bi', $modules) ? 'checked' : '' ?>>
                                                <label class="form-check-label text-white" for="plan_bi_<?= $key ?>">BI Telemetry</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="modules[]" value="finance" id="plan_fin_<?= $key ?>" class="form-check-input" <?= in_array('finance', $modules) ? 'checked' : '' ?>>
                                                <label class="form-check-label text-white" for="plan_fin_<?= $key ?>">Finance & Invoices</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="modules[]" value="placement" id="plan_plc_<?= $key ?>" class="form-check-input" <?= in_array('placement', $modules) ? 'checked' : '' ?>>
                                                <label class="form-check-label text-white" for="plan_plc_<?= $key ?>">Placement Cell</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="modules[]" value="automation" id="plan_aut_<?= $key ?>" class="form-check-input" <?= in_array('automation', $modules) ? 'checked' : '' ?>>
                                                <label class="form-check-label text-white" for="plan_aut_<?= $key ?>">Marketing Automation</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer px-4 py-3" style="background: #0F1620; border-top: 1px solid rgba(243,238,226,0.14);">
                                    <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-warning rounded-pill px-4 font-weight-bold" style="background: #D9AE68; color: #0F1620; border: none;">Save Plan Settings</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="row">
    <!-- Expiring Subscriptions & Renewal Alerts Table -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden h-100" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.14) !important;">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background: #0F1620; border-bottom: 1px solid rgba(243,238,226,0.14);">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-exclamation-triangle text-warning mr-2"></i>Expiring Subscriptions & Renewal Alerts</h6>
                <span class="badge badge-danger px-2 py-1 font-weight-bold"><?= count($expiringTenants) ?> Due</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="color: #F3EEE2;">
                        <thead style="background: #0F1620; color: #D9AE68;">
                            <tr>
                                <th class="border-0 px-3 py-2" style="font-size: 11px;">Tenant Academy</th>
                                <th class="border-0 py-2" style="font-size: 11px;">Plan</th>
                                <th class="border-0 py-2" style="font-size: 11px;">Expiration Date</th>
                                <th class="border-0 py-2 text-right pr-3" style="font-size: 11px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($expiringTenants)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted" style="color: #94A3B8;">No subscriptions expiring soon. All client accounts healthy.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($expiringTenants as $et): ?>
                                    <tr style="border-bottom: 1px solid rgba(243,238,226,0.08);">
                                        <td class="px-3 py-2">
                                            <div class="font-weight-bold text-white mb-0"><?= \App\Helpers\Security::e($et['name']) ?></div>
                                            <small style="color: #94A3B8;"><?= \App\Helpers\Security::e($et['subdomain']) ?>.localhost</small>
                                        </td>
                                        <td>
                                            <span class="badge px-2 py-1" style="background: rgba(217,174,104,0.15); color: #D9AE68; border: 1px solid rgba(217,174,104,0.3);"><?= \App\Helpers\Security::e($et['plan_name']) ?></span>
                                        </td>
                                        <td>
                                            <span class="text-warning font-weight-bold"><?= $et['expires_formatted'] ?></span>
                                            <small class="d-block" style="color: #94A3B8;"><?= $et['days_left'] ?> days remaining</small>
                                        </td>
                                        <td class="text-right pr-3">
                                            <form action="<?= \App\Helpers\Url::to('/admin/subscriptions/reminder/' . $et['id']) ?>" method="POST" class="d-inline">
                                                <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-3" style="font-size: 11px;">
                                                    <i class="fas fa-paper-plane mr-1"></i>Remind
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tenant Resource Capacity & Limit Exhaustion Heatmap -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden h-100" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.14) !important;">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background: #0F1620; border-bottom: 1px solid rgba(243,238,226,0.14);">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-chart-pie text-info mr-2"></i>Tenant Capacity & Limit Exhaustion Heatmap</h6>
                <span class="badge badge-info px-2 py-1 font-weight-bold">Live Resource Usage</span>
            </div>
            <div class="card-body p-3" style="max-height: 350px; overflow-y: auto;">
                <?php foreach ($tenants as $t): ?>
                    <?php 
                        $stats = $tenantStats[$t['id']] ?? [];
                        $leadCurrent = $stats['leads']['current'] ?? 0;
                        $leadMax = $stats['leads']['max'] === 'Unlimited' ? -1 : (int)($stats['leads']['max'] ?? 100);
                        $leadPct = $leadMax > 0 ? min(100, round(($leadCurrent / $leadMax) * 100)) : 10;

                        $courseCurrent = $stats['courses']['current'] ?? 0;
                        $courseMax = $stats['courses']['max'] === 'Unlimited' ? -1 : (int)($stats['courses']['max'] ?? 5);
                        $coursePct = $courseMax > 0 ? min(100, round(($courseCurrent / $courseMax) * 100)) : 10;
                    ?>
                    <div class="mb-3 p-3 rounded" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.1);">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="font-weight-bold text-white">#<?= $t['id'] ?> — <?= \App\Helpers\Security::e($t['name']) ?></span>
                            <span class="badge px-2 py-1" style="background: rgba(59,130,246,0.15); color: #60A5FA;"><?= \App\Helpers\Security::e($t['plan_name']) ?> Tier</span>
                        </div>
                        
                        <!-- Lead Usage Progress Bar -->
                        <div class="small d-flex justify-content-between mb-1" style="color: #94A3B8;">
                            <span>Lead Capacity</span>
                            <span><strong><?= $leadCurrent ?></strong> / <?= $leadMax === -1 ? '∞' : $leadMax ?> (<?= $leadPct ?>%)</span>
                        </div>
                        <div class="progress mb-2" style="height: 6px; background: rgba(243,238,226,0.1);">
                            <div class="progress-bar <?= $leadPct >= 80 ? 'bg-danger' : 'bg-primary' ?>" role="progressbar" style="width: <?= $leadPct ?>%;"></div>
                        </div>

                        <!-- Course Usage Progress Bar -->
                        <div class="small d-flex justify-content-between mb-1" style="color: #94A3B8;">
                            <span>Course Capacity</span>
                            <span><strong><?= $courseCurrent ?></strong> / <?= $courseMax === -1 ? '∞' : $courseMax ?> (<?= $coursePct ?>%)</span>
                        </div>
                        <div class="progress" style="height: 6px; background: rgba(243,238,226,0.1);">
                            <div class="progress-bar <?= $coursePct >= 80 ? 'bg-warning' : 'bg-success' ?>" role="progressbar" style="width: <?= $coursePct ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Create New Subscription Tier Modal -->
<div class="modal fade" id="newPlanModal" tabindex="-1" role="dialog" aria-labelledby="newPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content text-white" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.2);">
            <div class="modal-header text-white" style="background: #0F1620; border-bottom: 1px solid rgba(243,238,226,0.14);">
                <h5 class="modal-title font-weight-bold" id="newPlanModalLabel" style="color: #D9AE68;">Build New Custom Subscription Tier</h5>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= \App\Helpers\Url::to('/admin/subscriptions/plans') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold" style="color: #D9AE68;">Plan Code Key (Unique, e.g. Platinum)</label>
                            <input type="text" name="plan_key" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" placeholder="Platinum" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold" style="color: #D9AE68;">Tier Display Name</label>
                            <input type="text" name="name" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" placeholder="Platinum Class" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold" style="color: #D9AE68;">Monthly Price (₹)</label>
                            <input type="number" step="0.01" name="price" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" placeholder="19999.00" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold" style="color: #D9AE68;">Billing Cycle</label>
                            <select name="billing_cycle" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);">
                                <option value="monthly">Monthly Recurring</option>
                                <option value="annual">Annual Billing</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold" style="color: #D9AE68;">Max Leads / mo (-1 = Unlimited)</label>
                            <input type="number" name="max_leads" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" value="5000" required>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold" style="color: #D9AE68;">Max Courses (-1 = Unlimited)</label>
                            <input type="number" name="max_courses" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" value="50" required>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold" style="color: #D9AE68;">Max Students (-1 = Unlimited)</label>
                            <input type="number" name="max_students" class="form-control text-white" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.2);" value="5000" required>
                        </div>
                    </div>
                    <hr style="border-color: rgba(243,238,226,0.14);">
                    <label class="font-weight-bold mb-2" style="color: #D9AE68;">Granted Modules for this Custom Tier</label>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="crm" id="new_plan_crm" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_plan_crm">Lead CRM & Sales</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="lms" id="new_plan_lms" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_plan_lms">LMS & Courses</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="bi" id="new_plan_bi" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_plan_bi">BI Telemetry</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="finance" id="new_plan_fin" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_plan_fin">Finance & Invoices</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="placement" id="new_plan_plc" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_plan_plc">Placement Cell</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="modules[]" value="automation" id="new_plan_aut" class="form-check-input" checked>
                                <label class="form-check-label text-white" for="new_plan_aut">Marketing Automation</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="background: #0F1620; border-top: 1px solid rgba(243,238,226,0.14);">
                    <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 font-weight-bold" style="background: #D9AE68; color: #0F1620; border: none;">Build Tier</button>
                </div>
            </form>
        </div>
    </div>
</div>
