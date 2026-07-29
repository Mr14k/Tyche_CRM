<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Executive BI Telemetry & Reporting Engine</h2>
        <p class="text-secondary small m-0">Real-time organizational KPIs across revenue, admissions, conversion rates, and placements</p>
    </div>
    <div class="dropdown">
        <button class="btn btn-gold btn-sm px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-download"></i> Export System Reports (CSV)
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="background:#161F2B; border:1px solid rgba(243,238,226,0.14);">
            <li><a class="dropdown-item text-light small" href="<?= Url::to('/admin/bi/export?type=admissions') ?>"><i class="bi bi-file-earmark-spreadsheet text-success me-2"></i> Export Admissions Report</a></li>
            <li><a class="dropdown-item text-light small" href="<?= Url::to('/admin/bi/export?type=revenue') ?>"><i class="bi bi-file-earmark-spreadsheet text-warning me-2"></i> Export Revenue & Fee Ledger</a></li>
            <li><a class="dropdown-item text-light small" href="<?= Url::to('/admin/bi/export?type=invoices') ?>"><i class="bi bi-file-earmark-spreadsheet text-info me-2"></i> Export 18% GST Tax Invoices</a></li>
        </ul>
    </div>
</div>

<!-- Executive Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-4 text-center">
            <div class="text-secondary small uppercase tracking-wider mb-1 font-monospace">TOTAL ENROLLED STUDENTS</div>
            <div class="h2 font-monospace text-warning m-0"><?= number_format($metrics['total_students']) ?></div>
            <div class="text-success small mt-2"><i class="bi bi-arrow-up-right"></i> Active Cohort</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 text-center">
            <div class="text-secondary small uppercase tracking-wider mb-1 font-monospace">GROSS REVENUE (INR)</div>
            <div class="h2 font-monospace text-success m-0">₹ <?= number_format($metrics['total_revenue'], 2) ?></div>
            <div class="text-info small mt-2"><i class="bi bi-shield-check"></i> 18% GST Compliant</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 text-center">
            <div class="text-secondary small uppercase tracking-wider mb-1 font-monospace">LEAD CONVERSION RATE</div>
            <div class="h2 font-monospace text-info m-0"><?= $metrics['conversion_rate'] ?>%</div>
            <div class="text-secondary small mt-2"><?= $metrics['enrolled_leads'] ?> of <?= $metrics['total_leads'] ?> Leads</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 text-center">
            <div class="text-secondary small uppercase tracking-wider mb-1 font-monospace">BUSINESS HEALTH SCORE</div>
            <div class="h2 font-monospace text-warning m-0"><?= $metrics['business_health_score'] ?> / 100</div>
            <div class="text-success small mt-2"><i class="bi bi-heart-pulse-fill"></i> Enterprise Ready</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-pie-chart-fill me-2"></i> Departmental Telemetry & Revenue Breakdowns</h5>
            <div class="p-4 rounded text-center" style="background:#0F1620; border:1px solid rgba(243,238,226,0.14);">
                <div class="display-6 font-monospace text-light mb-2">₹ <?= number_format($metrics['total_revenue'], 2) ?></div>
                <p class="text-secondary small m-0">Aggregated real-time financial collection, course completions (<?= $metrics['total_certificates'] ?> issued), and active corporate hiring drives (<?= $metrics['active_jobs'] ?> active job postings).</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-award-fill me-2"></i> Placement & Certificate Telemetry</h5>
            <ul class="list-group list-group-flush bg-transparent">
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>Valid Certificates Issued</span>
                    <strong class="font-monospace text-warning"><?= $metrics['total_certificates'] ?></strong>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>Active Placement Jobs</span>
                    <strong class="font-monospace text-info"><?= $metrics['active_jobs'] ?></strong>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>GST Tax Invoices</span>
                    <strong class="font-monospace text-success">Compliant</strong>
                </li>
            </ul>
        </div>
    </div>
</div>
