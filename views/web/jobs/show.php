<?php
// Uses layouts/web.php
?>

<div class="hero-light py-5">
    <div class="container">
        <a href="<?= Url::to('/jobs') ?>" class="text-primary font-monospace small text-decoration-none fw-bold"><i class="bi bi-arrow-left me-1"></i> Back to All Placement Openings</a>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <h1 class="h2 font-heading text-slate-900 fw-bold m-0"><?= Security::e($job['title']) ?></h1>
                <div class="text-primary font-monospace mt-1"><i class="bi bi-building me-1"></i> <?= Security::e($job['company_name'] ?? 'Partner Employer') ?> • <?= Security::e($job['location']) ?></div>
            </div>
            <div class="text-end">
                <div class="h3 text-slate-900 font-heading fw-bold m-0"><?= Security::e($job['salary_range']) ?></div>
                <span class="badge bg-success text-white font-monospace mt-1">ACTIVE OPENING</span>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card-edtech p-4 mb-4 bg-white border-slate-200">
                <h5 class="h6 font-heading text-slate-900 fw-bold mb-3">Job Description & Role Responsibilities</h5>
                <div class="text-slate-700 lead-sm" style="white-space:pre-line; font-size:15px; line-height:1.7;"><?= Security::e($job['description']) ?></div>
            </div>

            <div class="card-edtech p-4 bg-white border-slate-200">
                <h5 class="h6 font-heading text-slate-900 fw-bold mb-3">Qualifications & Skill Requirements</h5>
                <div class="text-slate-700 lead-sm" style="white-space:pre-line; font-size:15px; line-height:1.7;"><?= Security::e($job['requirements']) ?></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-edtech p-4 bg-white border-slate-200">
                <h5 class="h6 font-heading text-slate-900 fw-bold mb-3">Apply for this Role</h5>
                <p class="text-slate-600 small">Submit your resume profile to the Tyche Placement Cell for direct recruiter referral.</p>
                <?php if (\App\Core\Session::has('user')): ?>
                    <form action="<?= Url::to('/student/assignments') ?>" method="GET">
                        <button type="submit" class="btn btn-primary-edtech btn-sm w-100 fw-bold py-2"><i class="bi bi-send-fill me-1"></i> Submit Application</button>
                    </form>
                <?php else: ?>
                    <a href="<?= Url::to('/login') ?>" class="btn btn-outline-edtech btn-sm w-100 fw-bold py-2">Login to Student Account to Apply</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
