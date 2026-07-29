<?php
// Uses layouts/web.php
?>

<div class="hero-light text-center py-5">
    <div class="container py-4">
        <span class="badge-pill-accent mb-2"><i class="bi bi-briefcase-fill me-1"></i> PLACEMENT & CAREER SERVICES</span>
        <h1 class="display-5 font-heading fw-bold text-slate-900 mb-3">Tyche Hiring Partner Openings</h1>
        <p class="lead text-slate-600 mx-auto" style="max-width: 680px;">Exclusively curated digital marketing, technical SEO, performance marketing, and analytics career opportunities for Tyche graduates.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <?php if (empty($jobs)): ?>
            <div class="col-12 text-center text-slate-500 py-5">No open placement listings available right now.</div>
        <?php else: ?>
            <?php foreach ($jobs as $j): ?>
                <div class="col-md-6">
                    <div class="card-edtech p-4 h-100 d-flex flex-column justify-content-between bg-white border-slate-200">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary-subtle text-primary font-monospace px-3 py-2 rounded-pill"><?= strtoupper($j['type']) ?></span>
                                <span class="text-primary font-heading fw-bold fs-5"><?= Security::e($j['salary_range']) ?></span>
                            </div>
                            <h3 class="h5 font-heading text-slate-900 fw-bold mb-1"><?= Security::e($j['title']) ?></h3>
                            <div class="text-slate-500 small mb-3"><i class="bi bi-building me-1"></i> <?= Security::e($j['company_name'] ?? 'Partner Employer') ?> • <i class="bi bi-geo-alt me-1"></i> <?= Security::e($j['location']) ?></div>
                            <p class="text-slate-600 small mb-3" style="display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;"><?= Security::e($j['description']) ?></p>
                        </div>
                        <div>
                            <a href="<?= Url::to('/jobs/' . $j['slug']) ?>" class="btn btn-primary-edtech btn-sm w-100 fw-bold">View Job Details & Apply</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
