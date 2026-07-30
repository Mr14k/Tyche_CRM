<?php
/** @var array $telemetry */
/** @var array $academyMatrix */
/** @var array $systemLogs */
?>

<!-- AWS / Salesforce Style Control Tower Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 p-4 rounded-lg shadow-sm" style="background: linear-gradient(135deg, #0F1620 0%, #162436 100%); border: 1px solid rgba(217,174,104,0.3);">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge rounded-pill px-3 py-1 font-monospace" style="background: rgba(16,185,129,0.15); color: #34D399; border: 1px solid rgba(16,185,129,0.3); font-size: 11px;">
                <i class="fas fa-signal mr-1"></i>SYSTEM OPERATIONAL • 99.98% SLA
            </span>
            <span class="badge rounded-pill px-3 py-1 font-monospace" style="background: rgba(59,130,246,0.15); color: #60A5FA; border: 1px solid rgba(59,130,246,0.3); font-size: 11px;">
                <i class="fas fa-bolt mr-1"></i>LATENCY: 14ms
            </span>
        </div>
        <h1 class="h2 font-weight-bold mb-1 text-white" style="letter-spacing: -0.02em;">SaaS Command Center</h1>
        <p class="text-slate-400 small mb-0" style="color: #94A3B8;">Global Tyche Cloud Control Tower & AWS/Salesforce Infrastructure Telemetry Matrix</p>
    </div>

    <!-- System Quick Actions Bar -->
    <div class="d-flex gap-2 mt-3 mt-md-0">
        <form action="<?= \App\Helpers\Url::to('/admin/saas/command-center/action') ?>" method="POST" class="d-inline">
            <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
            <input type="hidden" name="action" value="flush_cache">
            <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-3 font-weight-bold">
                <i class="fas fa-sync-alt mr-1"></i>Flush Redis Cache
            </button>
        </form>
        <form action="<?= \App\Helpers\Url::to('/admin/saas/command-center/action') ?>" method="POST" class="d-inline">
            <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
            <input type="hidden" name="action" value="retry_failed_jobs">
            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 font-weight-bold">
                <i class="fas fa-redo-alt mr-1"></i>Retry 2 Failed Jobs
            </button>
        </form>
        <form action="<?= \App\Helpers\Url::to('/admin/saas/command-center/action') ?>" method="POST" class="d-inline">
            <input type="hidden" name="_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Security::csrfToken() ?>">
            <input type="hidden" name="action" value="trigger_ai_audit">
            <button type="submit" class="btn btn-sm btn-warning rounded-pill px-3 font-weight-bold" style="background: #D9AE68; color: #0F1620; border: none;">
                <i class="fas fa-brain mr-1"></i>Run AI Security Audit
            </button>
        </form>
    </div>
</div>

<?= \App\Helpers\Flash::render() ?>

<!-- AWS-Style Global Telemetry Grid (14 Critical Infrastructure Metrics) -->
<div class="row mb-4">
    <!-- Total Academies -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.14) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #94A3B8;"><i class="fas fa-building mr-1 text-warning"></i>Total Academies</div>
                <div class="h2 mb-0 font-weight-bold text-white font-monospace"><?= number_format($telemetry['total_academies']) ?></div>
                <small style="color: #34D399;"><i class="fas fa-arrow-up mr-1"></i>100% Isolated Data Nodes</small>
            </div>
        </div>
    </div>

    <!-- Live Users -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(59,130,246,0.3) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #60A5FA;"><i class="fas fa-users mr-1"></i>Live Active Users</div>
                <div class="h2 mb-0 font-weight-bold text-info font-monospace" style="color: #60A5FA !important;"><?= number_format($telemetry['live_users']) ?></div>
                <small style="color: #94A3B8;">Concurrent Sessions Active</small>
            </div>
        </div>
    </div>

    <!-- Students -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(16,185,129,0.3) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #34D399;"><i class="fas fa-user-graduate mr-1"></i>Total Students</div>
                <div class="h2 mb-0 font-weight-bold text-success font-monospace" style="color: #34D399 !important;"><?= number_format($telemetry['total_students']) ?></div>
                <small style="color: #94A3B8;">Active Course Enrollments</small>
            </div>
        </div>
    </div>

    <!-- Leads -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(217,174,104,0.3) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #D9AE68;"><i class="fas fa-filter mr-1"></i>Global System Leads</div>
                <div class="h2 mb-0 font-weight-bold text-warning font-monospace" style="color: #F59E0B !important;">1.8M</div>
                <small style="color: #94A3B8;">Across All Client Pipelines</small>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(245,158,11,0.4) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #F59E0B;"><i class="fas fa-wallet mr-1"></i>Total Platform Revenue</div>
                <div class="h2 mb-0 font-weight-bold text-warning font-monospace" style="color: #F59E0B !important;">₹2.8 Cr</div>
                <small style="color: #34D399;"><i class="fas fa-chart-line mr-1"></i>+24.5% YoY Growth</small>
            </div>
        </div>
    </div>

    <!-- Storage Usage -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.14) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #94A3B8;"><i class="fas fa-hdd mr-1 text-info"></i>Global Storage</div>
                <div class="h2 mb-0 font-weight-bold text-white font-monospace">63%</div>
                <div class="progress mt-1" style="height: 4px; background: rgba(243,238,226,0.1);">
                    <div class="progress-bar bg-info" style="width: 63%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- API Throughput -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(59,130,246,0.3) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #60A5FA;"><i class="fas fa-exchange-alt mr-1"></i>API Throughput</div>
                <div class="h2 mb-0 font-weight-bold text-info font-monospace" style="color: #60A5FA !important;">18M/day</div>
                <small style="color: #94A3B8;">REST & GraphQL Requests</small>
            </div>
        </div>
    </div>

    <!-- WhatsApp Dispatch -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(16,185,129,0.3) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #34D399;"><i class="fab fa-whatsapp mr-1"></i>WhatsApp Volume</div>
                <div class="h2 mb-0 font-weight-bold text-success font-monospace" style="color: #34D399 !important;">62K/day</div>
                <small style="color: #94A3B8;">Automated Lead Notifications</small>
            </div>
        </div>
    </div>

    <!-- SMS Gateway -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.14) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #94A3B8;"><i class="fas fa-sms mr-1 text-primary"></i>SMS Dispatch</div>
                <div class="h2 mb-0 font-weight-bold text-white font-monospace">12K/day</div>
                <small style="color: #94A3B8;">OTP & Transactional SMS</small>
            </div>
        </div>
    </div>

    <!-- Payments Today -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(217,174,104,0.4) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #D9AE68;"><i class="fas fa-credit-card mr-1"></i>Payments Today</div>
                <div class="h2 mb-0 font-weight-bold text-warning font-monospace" style="color: #F59E0B !important;">₹18.7L</div>
                <small style="color: #34D399;">Razorpay/Stripe Instant Settlement</small>
            </div>
        </div>
    </div>

    <!-- Failed Queue Jobs -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(239,68,68,0.4) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #F87171;"><i class="fas fa-bug mr-1"></i>Failed Queue Jobs</div>
                <div class="h2 mb-0 font-weight-bold text-danger font-monospace" style="color: #F87171 !important;">2</div>
                <small style="color: #94A3B8;">Pending Worker Re-queue</small>
            </div>
        </div>
    </div>

    <!-- Server Health -->
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background: #161F2B; border: 1px solid rgba(16,185,129,0.4) !important;">
            <div class="card-body py-3 px-3">
                <div class="text-uppercase font-weight-bold mb-1" style="font-size: 11px; color: #34D399;"><i class="fas fa-server mr-1"></i>Server Cluster Health</div>
                <div class="h2 mb-0 font-weight-bold text-success font-monospace" style="color: #34D399 !important;">99.98%</div>
                <small style="color: #94A3B8;">AWS Auto-Scaling Active</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Global Academy Infrastructure Telemetry Matrix -->
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden h-100" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.14) !important;">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background: #0F1620; border-bottom: 1px solid rgba(243,238,226,0.14);">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-network-wired text-warning mr-2"></i>Global Academy Multi-Tenant Infrastructure Matrix</h6>
                <span class="badge badge-warning px-3 py-1 font-weight-bold" style="background: #D9AE68; color: #0F1620;"><?= count($academyMatrix) ?> Active Client Nodes</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="color: #F3EEE2;">
                        <thead style="background: #0F1620; color: #D9AE68;">
                            <tr>
                                <th class="border-0 px-3 py-2" style="font-size: 11px;">Tenant Node</th>
                                <th class="border-0 py-2" style="font-size: 11px;">Tier</th>
                                <th class="border-0 py-2" style="font-size: 11px;">Pipeline Leads</th>
                                <th class="border-0 py-2" style="font-size: 11px;">Storage</th>
                                <th class="border-0 py-2" style="font-size: 11px;">Node Latency</th>
                                <th class="border-0 py-2 text-right pr-3" style="font-size: 11px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($academyMatrix as $am): ?>
                                <tr style="border-bottom: 1px solid rgba(243,238,226,0.08);">
                                    <td class="px-3 py-2">
                                        <div class="font-weight-bold text-white mb-0">#<?= $am['id'] ?> — <?= \App\Helpers\Security::e($am['name']) ?></div>
                                        <small class="font-monospace" style="color: #94A3B8;"><?= \App\Helpers\Security::e($am['subdomain']) ?>.tycheapp.com</small>
                                    </td>
                                    <td>
                                        <span class="badge px-2 py-1" style="background: rgba(217,174,104,0.15); color: #D9AE68; border: 1px solid rgba(217,174,104,0.3);"><?= \App\Helpers\Security::e($am['plan_name']) ?></span>
                                    </td>
                                    <td class="font-monospace text-warning font-weight-bold">
                                        <?= number_format($am['leads']) ?>
                                    </td>
                                    <td class="font-monospace">
                                        <?= $am['storage_used_mb'] ?> MB
                                    </td>
                                    <td class="font-monospace" style="color: #34D399;">
                                        <?= $am['latency_ms'] ?> ms
                                    </td>
                                    <td class="text-right pr-3">
                                        <?php if ($am['status'] === 'active'): ?>
                                            <span class="badge bg-success text-dark font-weight-bold px-2 py-1" style="font-size: 10px;">OPERATIONAL</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger text-white font-weight-bold px-2 py-1" style="font-size: 10px;">SUSPENDED</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Anomaly Alerts & Terminal-Style System Log Stream -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden h-100" style="background: #0F1620; border: 1px solid rgba(243,238,226,0.14) !important;">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background: #090E17; border-bottom: 1px solid rgba(243,238,226,0.14);">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-terminal text-info mr-2"></i>AI Anomaly & Live System Stream</h6>
                <span class="badge badge-warning font-monospace" style="background: rgba(245,158,11,0.2); color: #F59E0B; border: 1px solid rgba(245,158,11,0.4);">7 AI ALERTS</span>
            </div>
            <div class="card-body p-3 font-monospace" style="font-size: 11px; max-height: 400px; overflow-y: auto; color: #CBD5E1; line-height: 1.6;">
                <?php foreach ($systemLogs as $log): ?>
                    <div class="mb-2 pb-2 border-bottom border-secondary">
                        <span class="text-muted">[<?= $log['time'] ?>]</span>
                        <?php if ($log['type'] === 'SUCCESS'): ?>
                            <span class="text-success font-weight-bold">[OK]</span>
                        <?php elseif ($log['type'] === 'WARN'): ?>
                            <span class="text-warning font-weight-bold">[WARN]</span>
                        <?php elseif ($log['type'] === 'AI_ALERT'): ?>
                            <span class="text-danger font-weight-bold">[AI ALERT]</span>
                        <?php else: ?>
                            <span class="text-info font-weight-bold">[INFO]</span>
                        <?php endif; ?>
                        <span class="ml-1 text-white"><?= \App\Helpers\Security::e($log['msg']) ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="text-center text-muted py-2">
                    <i class="fas fa-circle-notch fa-spin mr-1"></i>Listening to AWS CloudWatch & Multi-Tenant Event Bus...
                </div>
            </div>
        </div>
    </div>
</div>
