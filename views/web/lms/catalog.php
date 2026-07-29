<?php
// Uses layouts/web.php
?>

<div class="hero-light text-center py-5">
    <div class="container py-4">
        <span class="badge-pill-accent mb-2"><i class="bi bi-journal-bookmark-fill me-1"></i> ACADEMIC CATALOG</span>
        <h1 class="display-5 font-heading fw-bold text-slate-900 mb-3">Tyche Academic Masterclasses</h1>
        <p class="lead text-slate-600 mx-auto" style="max-width: 680px;">Structured 4-module curriculum built for high-performance digital marketing, performance ads, and AI search discovery.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <?php foreach ($courses as $c): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card-edtech p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary-subtle text-primary font-monospace px-3 py-2 rounded-pill"><?= Security::e($c['code']) ?></span>
                            <span class="badge bg-slate-100 text-slate-700 font-monospace px-2 py-1 rounded"><?= Security::e($c['category_name'] ?? 'Digital Marketing') ?></span>
                        </div>
                        <h3 class="h5 font-heading fw-bold text-slate-900 mb-2"><?= Security::e($c['title']) ?></h3>
                        <p class="text-slate-600 small mb-4" style="display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;"><?= Security::e($c['short_description'] ?? '') ?></p>
                    </div>
                    <div class="pt-3 border-top border-slate-200 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-slate-500 font-monospace" style="font-size:11px;">COURSE FEE</div>
                            <span class="font-heading text-slate-900 fw-bold fs-5">₹ <?= number_format((float)$c['price'], 2) ?></span>
                        </div>
                        <a href="<?= Url::to('/courses/' . $c['slug']) ?>" class="btn btn-primary-edtech btn-sm py-2 px-3">Explore Curriculum →</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
