<?php
/** @var array $tenants */
/** @var array $plans */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-gray-800 font-weight-bold mb-1">SaaS Pilot Client Academies</h1>
        <p class="text-muted small mb-0">Provision and manage multi-tenant pilot client accounts (Target: 10–20 Clients)</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm rounded-pill px-4" data-toggle="modal" data-target="#newTenantModal" data-bs-toggle="modal" data-bs-target="#newTenantModal">
        <i class="fas fa-plus mr-2"></i>Provision New Academy
    </button>
</div>

<?= \App\Helpers\Flash::render() ?>

<!-- Subscription Tier Summary Cards -->
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
                        <th class="border-0 px-4 py-3">ID</th>
                        <th class="border-0 py-3">Academy Name</th>
                        <th class="border-0 py-3">Subdomain / Domain</th>
                        <th class="border-0 py-3">Admin Email</th>
                        <th class="border-0 py-3">Subscription Tier</th>
                        <th class="border-0 py-3">Status</th>
                        <th class="border-0 py-3 text-right pr-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tenants)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No pilot academies found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tenants as $t): ?>
                            <tr>
                                <td class="px-4 font-weight-bold">#<?= $t['id'] ?></td>
                                <td class="font-weight-bold text-dark"><?= \App\Helpers\Security::e($t['name']) ?></td>
                                <td>
                                    <span class="badge badge-soft-primary px-3 py-1 font-monospace">
                                        <?= \App\Helpers\Security::e($t['subdomain']) ?>.localhost
                                    </span>
                                </td>
                                <td><?= \App\Helpers\Security::e($t['email']) ?></td>
                                <td>
                                    <form action="<?= \App\Helpers\Url::to('/admin/tenants/' . $t['id'] . '/plan') ?>" method="POST" class="d-inline-flex">
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
                                    <?php if ($t['status'] === 'active'): ?>
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning px-2 py-1"><?= \App\Helpers\Security::e($t['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right pr-4">
                                    <a href="<?= \App\Helpers\Url::to('/dashboard?t=' . $t['subdomain']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="fas fa-external-link-alt mr-1"></i>Switch Workspace
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Provision New Tenant Modal -->
<div class="modal fade" id="newTenantModal" tabindex="-1" role="dialog" aria-labelledby="newTenantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold" id="newTenantModalLabel">Provision New Pilot Client Academy</h5>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= \App\Helpers\Url::to('/admin/tenants') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Academy Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Apex Marketing Academy" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Subdomain Identifier</label>
                        <div class="input-group">
                            <input type="text" name="subdomain" class="form-control" placeholder="apex" required>
                            <div class="input-group-append">
                                <span class="input-group-text bg-light">.localhost</span>
                            </div>
                        </div>
                        <small class="text-muted">Users can switch tenant via <code>?t=subdomain</code> or subdomain URL.</small>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Client Admin Email</label>
                        <input type="email" name="admin_email" class="form-control" placeholder="admin@apexacademy.com" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Client Admin Password</label>
                        <input type="password" name="admin_password" class="form-control" placeholder="Create temporary password" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">Subscription Tier & Limits</label>
                        <select name="plan_name" class="form-control">
                            <option value="Bronze">Bronze Tier (100 Leads / 5 Courses / 100 Students)</option>
                            <option value="Silver">Silver Tier (1,000 Leads / 25 Courses / 1k Students)</option>
                            <option value="Gold">Gold Tier (10,000 Leads / 100 Courses / 10k Students)</option>
                            <option value="Enterprise">Enterprise Tier (Unlimited Everything + White-Label)</option>
                        </select>
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
