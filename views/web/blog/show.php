<?php
// Uses layouts/web.php
?>

<div class="hero-light py-5">
    <div class="container text-center max-w-3xl" style="max-width: 800px;">
        <a href="<?= Url::to('/blog') ?>" class="text-primary font-monospace small text-decoration-none fw-bold"><i class="bi bi-arrow-left me-1"></i> Back to Blog Directory</a>
        <div class="mt-3">
            <span class="badge bg-primary text-white font-monospace px-3 py-2 rounded-pill mb-3"><?= Security::e($post['category_name'] ?? 'Insights') ?></span>
            <h1 class="display-5 font-heading fw-bold text-slate-900 mb-3"><?= Security::e($post['title']) ?></h1>
            <div class="text-slate-500 small font-monospace">
                By <?= Security::e($post['first_name'] . ' ' . $post['last_name']) ?> • Published <?= Format::date($post['published_at'], 'M d, Y') ?> • <?= $post['reading_time_minutes'] ?> min read
            </div>
        </div>
    </div>
</div>

<main class="container py-5" style="max-width: 820px;">
    <div class="card-edtech p-4 p-md-5 bg-white border-slate-200 text-slate-800 fs-5" style="line-height: 1.8;">
        <?= $post['content'] ?>
    </div>
</main>
