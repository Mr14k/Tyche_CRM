<?php
// Uses layouts/web.php
?>

<div class="hero-light text-center py-5">
    <div class="container py-4">
        <span class="badge-pill-accent mb-2"><i class="bi bi-newspaper me-1"></i> ACADEMY BLOG & INSIGHTS</span>
        <h1 class="display-5 font-heading fw-bold text-slate-900 mb-3">Digital Marketing & SEO Intelligence</h1>
        <p class="lead text-slate-600 mx-auto" style="max-width: 680px;">Insights on Generative Engine Optimization (GEO), Answer Engine Optimization (AEO), and DV360 Programmatic Ad Buying.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <?php foreach ($posts as $p): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card-edtech p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary-subtle text-primary font-monospace px-3 py-2 rounded-pill"><?= Security::e($p['category_name'] ?? 'Insights') ?></span>
                            <span class="small font-monospace text-slate-500"><i class="bi bi-clock me-1"></i> <?= $p['reading_time_minutes'] ?> min read</span>
                        </div>
                        <h3 class="h5 font-heading fw-bold text-slate-900 mb-2"><?= Security::e($p['title']) ?></h3>
                        <p class="text-slate-600 small mb-4" style="display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;"><?= Security::e($p['summary'] ?? '') ?></p>
                    </div>
                    <div class="pt-3 border-top border-slate-200 text-end">
                        <a href="<?= Url::to('/blog/' . $p['slug']) ?>" class="btn btn-outline-edtech btn-sm py-2 px-3">Read Article →</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
