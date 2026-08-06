<?php
use App\Helpers\Url;
use App\Helpers\Security;
?>

<div class="container-fluid py-4">
    <!-- Header Title & Quick Action Speed Dial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="font-weight-bold text-white mb-1">
                <i class="bi bi-pie-chart-fill text-gold me-2"></i>Executive Financial BI & Fee Recovery Hub
            </h3>
            <p class="text-muted small mb-0">Real-time revenue telemetry, 18% GST tax accounting ledger, and automated payment reminders.</p>
        </div>
        <div class="d-flex gap-2">
            <form action="<?= Url::to('/admin/finance/remind-all') ?>" method="POST" class="d-inline">
                <input type="hidden" name="_token" value="<?= $_SESSION['_csrf_token'] ?? '' ?>">
                <button type="submit" class="btn btn-gold font-monospace btn-sm py-2 px-3">
                    <i class="bi bi-bell-fill me-1"></i> Send Bulk Fee Reminders
                </button>
            </form>
            <a href="<?= Url::to('/admin/crm/leads') ?>" class="btn btn-indigo font-monospace btn-sm py-2 px-3">
                <i class="bi bi-plus-circle-fill me-1"></i> Record Desk Payment
            </a>
        </div>
    </div>

    <!-- 📊 Top BI Telemetry Cards (MTD, YTD, Today's Invoices, Total Revenue) -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 h-100 border-0" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(30, 41, 59, 0.9) 100%); border-left: 4px solid #10B981 !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-uppercase text-muted font-monospace small">Total Revenue (All Time)</span>
                    <div class="rounded-circle p-2" style="background: rgba(16, 185, 129, 0.2); color: #34D399;">
                        <i class="bi bi-cash-stack fs-5"></i>
                    </div>
                </div>
                <h2 class="text-white font-weight-bold mb-1">₹<?= number_format($totalRevenue, 2) ?></h2>
                <span class="text-muted small"><i class="bi bi-check-circle-fill text-success me-1"></i>Verified Completed Transactions</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 h-100 border-0" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.12) 0%, rgba(30, 41, 59, 0.9) 100%); border-left: 4px solid #6366F1 !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-uppercase text-muted font-monospace small">Month-to-Date (MTD)</span>
                    <div class="rounded-circle p-2" style="background: rgba(99, 102, 241, 0.2); color: #818CF8;">
                        <i class="bi bi-calendar-month fs-5"></i>
                    </div>
                </div>
                <h2 class="text-white font-weight-bold mb-1">₹<?= number_format($mtdRevenue, 2) ?></h2>
                <span class="text-muted small"><i class="bi bi-graph-up-arrow text-info me-1"></i>Current Month Collection</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 h-100 border-0" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(30, 41, 59, 0.9) 100%); border-left: 4px solid #F59E0B !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-uppercase text-muted font-monospace small">Year-to-Date (YTD)</span>
                    <div class="rounded-circle p-2" style="background: rgba(245, 158, 11, 0.2); color: #FBBF24;">
                        <i class="bi bi-calendar3 fs-5"></i>
                    </div>
                </div>
                <h2 class="text-white font-weight-bold mb-1">₹<?= number_format($ytdRevenue, 2) ?></h2>
                <span class="text-muted small"><i class="bi bi-shield-check text-warning me-1"></i>Fiscal Year <?= date('Y') ?></span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 h-100 border-0" style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.12) 0%, rgba(30, 41, 59, 0.9) 100%); border-left: 4px solid #06B6D4 !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-uppercase text-muted font-monospace small">Today's Invoices & Collection</span>
                    <div class="rounded-circle p-2" style="background: rgba(6, 182, 212, 0.2); color: #22D3EE;">
                        <i class="bi bi-receipt fs-5"></i>
                    </div>
                </div>
                <h2 class="text-white font-weight-bold mb-1">₹<?= number_format($todayRevenue, 2) ?></h2>
                <span class="text-muted small"><strong class="text-cyan"><?= $todayInvoicesCount ?></strong> Tax Invoices Generated Today</span>
            </div>
        </div>
    </div>

    <!-- 💳 Collection Channels & 🧾 Statutory 18% GST Ledger -->
    <div class="row g-3 mb-4">
        <!-- Collection Channels Breakdown -->
        <div class="col-lg-6">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-white mb-0"><i class="bi bi-wallet2 me-2 text-info"></i>Collection Channels</h5>
                    <span class="badge bg-secondary font-monospace">Real-Time Ledger</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Payment Method</th>
                                <th class="text-center">Total Transactions</th>
                                <th class="text-end">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($channelRows)): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">No payment transaction records found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($channelRows as $cr): ?>
                                    <tr>
                                        <td>
                                            <span class="badge font-monospace px-2 py-1 text-uppercase <?= str_contains(strtolower($cr['gateway']), 'cash') ? 'bg-success text-white' : 'bg-primary text-white' ?>">
                                                <?= Security::e($cr['gateway']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center font-monospace"><?= $cr['txn_count'] ?> txns</td>
                                        <td class="text-end font-weight-bold text-white">₹<?= number_format((float)$cr['channel_total'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Statutory 18% GST Tax Summary -->
        <div class="col-lg-6">
            <div class="card p-4 h-100" style="background: radial-gradient(circle at top right, rgba(217, 174, 104, 0.08) 0%, rgba(30, 41, 59, 1) 100%);">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-gold mb-0"><i class="bi bi-calculator-fill me-2"></i>Statutory 18% GST Tax Audit Ledger</h5>
                    <a href="<?= Url::to('/admin/finance/invoices') ?>" class="btn btn-outline-light btn-sm font-monospace">View All Invoices</a>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 rounded bg-dark border border-secondary">
                            <span class="text-muted small d-block">Taxable Value (Excl. Tax)</span>
                            <h4 class="text-white font-weight-bold mb-0">₹<?= number_format($gstSummary['totalTaxable'], 2) ?></h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded bg-dark border border-secondary">
                            <span class="text-muted small d-block">Total GST Liability (18%)</span>
                            <h4 class="text-warning font-weight-bold mb-0">₹<?= number_format($gstSummary['totalGst'], 2) ?></h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded bg-dark border border-secondary">
                            <span class="text-muted small d-block">CGST Collection (9%)</span>
                            <h5 class="text-info font-weight-bold mb-0">₹<?= number_format($gstSummary['cgst'], 2) ?></h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded bg-dark border border-secondary">
                            <span class="text-muted small d-block">SGST Collection (9%)</span>
                            <h5 class="text-info font-weight-bold mb-0">₹<?= number_format($gstSummary['sgst'], 2) ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔔 Upcoming & Overdue Fee Reminders Table -->
    <div class="card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="font-weight-bold text-white mb-0"><i class="bi bi-clock-history me-2 text-warning"></i>Pending & Upcoming Tuition Fee Installments</h5>
                <p class="text-muted small mb-0">Click 'Send Reminder' to dispatch an instant payment link via WhatsApp & Email.</p>
            </div>
            <span class="badge bg-warning text-dark font-monospace"><?= count($pendingLeads) ?> Outstanding Records</span>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Student / Lead Name</th>
                        <th>Phone & Email</th>
                        <th>Target Course</th>
                        <th>Current Stage</th>
                        <th>Fee Amount</th>
                        <th class="text-end">Quick Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendingLeads)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-check-circle fs-3 text-success d-block mb-2"></i>
                                All tuition installments and lead payments are up to date!
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pendingLeads as $pl): ?>
                            <tr>
                                <td>
                                    <strong class="text-white"><?= Security::e($pl['first_name'] . ' ' . $pl['last_name']) ?></strong>
                                    <span class="d-block text-muted small font-monospace">ID: #LD-<?= $pl['id'] ?></span>
                                </td>
                                <td>
                                    <span class="d-block text-info font-monospace"><i class="bi bi-telephone me-1"></i><?= Security::e($pl['phone']) ?></span>
                                    <span class="d-block text-muted small"><?= Security::e($pl['email']) ?></span>
                                </td>
                                <td><?= Security::e($pl['course_title'] ?? 'General Course') ?></td>
                                <td>
                                    <span class="badge badge-chip badge-<?= strtolower($pl['status'] ?? 'new') ?>">
                                        <?= Security::e($pl['status'] ?? 'NEW') ?>
                                    </span>
                                </td>
                                <td class="font-weight-bold text-gold">₹<?= number_format((float)($pl['fee_amount'] ?? 15000), 2) ?></td>
                                <td class="text-end">
                                    <form action="<?= Url::to('/admin/finance/remind/' . $pl['id']) ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="<?= $_SESSION['_csrf_token'] ?? '' ?>">
                                        <button type="submit" class="btn btn-outline-warning btn-sm font-monospace">
                                            <i class="bi bi-whatsapp me-1"></i> Send Reminder
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
