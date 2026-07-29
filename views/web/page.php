<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Security::e($seo['meta_title'] ?? $page['title']) ?> — Tyche Academy</title>
    <?php if (!empty($seo['meta_description'])): ?>
        <meta name="description" content="<?= Security::e($seo['meta_description']) ?>">
    <?php endif; ?>
    <?php if (!empty($seo['keywords'])): ?>
        <meta name="keywords" content="<?= Security::e($seo['keywords']) ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        :root {
            --bg: #0F1620;
            --bg-elevated: #161F2B;
            --parchment: #F3EEE2;
            --parchment-dim: #C9C2B2;
            --gold: #B98B3E;
            --gold-bright: #D9AE68;
            --line: rgba(243,238,226,0.14);
        }
        body { background: var(--bg); color: var(--parchment); font-family: 'Inter', system-ui, sans-serif; line-height: 1.7; }
        .page-header { background: var(--bg-elevated); padding: 80px 0 60px; border-bottom: 1px solid var(--line); }
        .page-body { padding: 60px 0; max-width: 860px; margin: 0 auto; }
        .brand-link { font-family: 'Fraunces', serif; font-size: 22px; color: var(--parchment); text-decoration: none; display: flex; align-items: center; gap: 10px; }
        footer { border-top: 1px solid var(--line); padding: 30px 0; color: #8B95A3; font-size: 13px; }
    </style>
</head>
<body>

<nav class="border-bottom border-secondary py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="<?= Url::to('/') ?>" class="brand-link">
            <svg width="28" height="28" viewBox="0 0 40 40" fill="none">
                <circle cx="20" cy="20" r="18" stroke="#B98B3E" stroke-width="1.4"/>
                <circle cx="20" cy="20" r="3" fill="#B98B3E"/>
                <path d="M20 4V13M20 27V36M4 20H13M27 20H36" stroke="#B98B3E" stroke-width="1.2"/>
            </svg>
            Tyche Academy
        </a>
        <a href="<?= Url::to('/') ?>" class="btn btn-outline-warning btn-sm">← Back to Main Page</a>
    </div>
</nav>

<header class="page-header text-center">
    <div class="container">
        <h1 class="display-4 fw-bold" style="color:var(--gold-bright);"><?= Security::e($page['title']) ?></h1>
        <div class="text-secondary small mt-2 font-monospace">Last updated <?= Format::date($page['updated_at'], 'M d, Y') ?></div>
    </div>
</header>

<main class="container page-body">
    <?= $page['content'] ?>
</main>

<footer>
    <div class="container text-center">
        <?= \App\Models\SiteSetting::get('footer_copyright', '© Tyche Digital Marketing Academy') ?>
    </div>
</footer>

</body>
</html>
