<?php
// Uses layouts/web.php
?>

<div class="hero-light py-5">
    <div class="container d-flex justify-content-center">
        <div class="card-edtech text-center p-5 bg-white border-primary shadow-lg" style="max-width: 680px; width: 100%;">
            <div class="mb-3">
                <span class="badge bg-success text-white font-monospace px-3 py-2 rounded-pill"><i class="bi bi-shield-check me-1"></i> VERIFIED OFFICIAL CREDENTIAL</span>
            </div>

            <h1 class="display-6 font-heading text-slate-900 fw-bold mb-2">Tyche Digital Marketing Academy</h1>
            <p class="text-slate-500 small font-monospace">Official Certificate of Completion & Academic Excellence</p>

            <hr class="border-slate-200 my-4">

            <p class="text-slate-500 mb-1">This certifies that</p>
            <h2 class="h3 font-heading text-primary fw-bold mb-3"><?= Security::e($certificate['first_name'] . ' ' . $certificate['last_name']) ?></h2>
            <p class="text-slate-500 mb-1">has successfully completed all requirements for</p>
            <h3 class="h4 text-slate-900 font-heading fw-bold mb-4"><?= Security::e($certificate['course_title']) ?></h3>

            <div class="bg-slate-50 p-4 rounded-3 border border-slate-200 mb-4 text-start font-monospace small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-slate-500">Certificate Code:</span>
                    <span class="text-primary fw-bold"><?= Security::e($certificate['certificate_code']) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-slate-500">Issue Date:</span>
                    <span class="text-slate-900"><?= Format::date($certificate['issue_date'], 'F d, Y') ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-slate-500">Verification Hash:</span>
                    <span class="text-slate-700 text-truncate" style="max-width:280px;"><?= Security::e($certificate['verification_hash']) ?></span>
                </div>
            </div>

            <a href="<?= Url::to('/') ?>" class="btn btn-outline-edtech btn-sm py-2 px-4">← Back to Tyche Academy</a>
        </div>
    </div>
</div>
