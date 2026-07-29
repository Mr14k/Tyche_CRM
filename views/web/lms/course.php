<?php
// Uses layouts/web.php
?>

<!-- SEO Schema JSON-LD for Course Page -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": <?= json_encode($course['title']) ?>,
  "description": <?= json_encode($course['short_description'] ?? '') ?>,
  "provider": {
    "@type": "EducationalOrganization",
    "name": "Tyche Digital Marketing Academy",
    "sameAs": "https://tyche.academy"
  },
  "offers": {
    "@type": "Offer",
    "category": "Educational",
    "price": <?= json_encode((float)$course['price']) ?>,
    "priceCurrency": "INR",
    "availability": "https://schema.org/InStock"
  }
}
</script>

<!-- ==================================================== -->
<!-- TOFU (TOP OF FUNNEL): HERO & AWARENESS SECTION -->
<!-- ==================================================== -->
<section class="hero-light py-5">
    <div class="container py-2">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb font-monospace small">
                <li class="breadcrumb-item"><a href="<?= Url::to('/courses') ?>" class="text-primary text-decoration-none"><i class="bi bi-arrow-left me-1"></i> All Courses</a></li>
                <li class="breadcrumb-item text-slate-500 active"><?= Security::e($course['code']) ?></li>
            </ol>
        </nav>

        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-primary text-white font-monospace px-3 py-2 rounded-pill"><?= Security::e($course['code']) ?></span>
                    <span class="badge bg-danger-subtle text-danger font-monospace px-3 py-2 rounded-pill"><i class="bi bi-cpu-fill me-1"></i> AEO & GEO READY</span>
                    <span class="badge bg-success-subtle text-success font-monospace px-3 py-2 rounded-pill"><i class="bi bi-briefcase-fill me-1"></i> PLACEMENT SUPPORT</span>
                </div>

                <h1 class="display-4 font-heading fw-extrabold text-slate-900 mb-3" style="line-height: 1.15; letter-spacing: -0.03em;">
                    <?= Security::e($course['title']) ?>
                </h1>

                <p class="lead text-slate-600 mb-4" style="font-size: 19px;">
                    <?= Security::e($course['short_description'] ?? 'Master search foundations, AI engine discovery, performance ad campaigns, and programmatic media buying in a structured 4-module blueprint.') ?>
                </p>

                <!-- High Trust Telemetry Row -->
                <div class="row g-3 py-3 mb-4 bg-white rounded-4 border border-slate-200 shadow-sm text-center">
                    <div class="col-6 col-md-3 border-end border-slate-200">
                        <div class="fw-bold font-heading text-slate-900 fs-5"><?= $course['duration_weeks'] ?> Weeks</div>
                        <div class="small text-slate-500 font-monospace" style="font-size:11px;">DURATION</div>
                    </div>
                    <div class="col-6 col-md-3 border-end-md border-slate-200">
                        <div class="fw-bold font-heading text-primary fs-5"><?= ucfirst($course['level']) ?></div>
                        <div class="small text-slate-500 font-monospace" style="font-size:11px;">EXPERIENCE</div>
                    </div>
                    <div class="col-6 col-md-3 border-end border-slate-200">
                        <div class="fw-bold font-heading text-slate-900 fs-5">SHA-256</div>
                        <div class="small text-slate-500 font-monospace" style="font-size:11px;">VERIFIED CERT</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="fw-bold font-heading text-success fs-5">100+</div>
                        <div class="small text-slate-500 font-monospace" style="font-size:11px;">HIRING PARTNERS</div>
                    </div>
                </div>

                <!-- Hero CTAs -->
                <div class="d-flex flex-wrap gap-3">
                    <a href="#courseEnrollForm" class="btn btn-primary-edtech py-3 px-4 fs-6">
                        Claim ₹500 Scholarship & Enroll <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    <a href="#syllabus" class="btn btn-outline-edtech py-3 px-4 fs-6">
                        View 4-Module Syllabus
                    </a>
                </div>
            </div>

            <!-- Sticky Course Pricing & Instant Lead Form Card -->
            <div class="col-lg-5">
                <div class="card-edtech p-4 p-md-5 bg-white border-primary shadow-lg position-relative">
                    <span class="position-absolute top-0 end-0 translate-middle-y me-4 badge bg-amber-500 text-dark fw-bold px-3 py-2 rounded-pill font-monospace" style="background:#F59E0B;">ADMISSIONS OPEN</span>
                    
                    <div class="text-center mb-4">
                        <div class="text-slate-500 font-monospace small">COURSE ENROLLMENT INVESTMENT</div>
                        <div class="d-flex align-items-baseline justify-content-center gap-2 my-1">
                            <span class="display-5 font-heading fw-bold text-primary">₹ <?= number_format((float)$course['price'], 2) ?></span>
                            <?php if (!empty($course['discount_price'])): ?>
                                <span class="text-slate-400 text-decoration-line-through font-monospace fs-5">₹ <?= number_format((float)$course['discount_price'], 2) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="small text-success font-monospace"><i class="bi bi-patch-check-fill me-1"></i> GST Tax Invoice Included • 18% Compliant</div>
                    </div>

                    <?php if ($isEnrolled): ?>
                        <div class="alert alert-success text-center font-monospace small mb-3">
                            <i class="bi bi-check-circle-fill me-1"></i> You are currently enrolled in this course!
                        </div>
                        <?php 
                            $firstLessonId = $hierarchy[0]['chapters'][0]['lessons'][0]['id'] ?? null;
                            if ($firstLessonId):
                        ?>
                            <a href="<?= Url::to('/courses/' . $course['slug'] . '/learn/' . $firstLessonId) ?>" class="btn btn-primary-edtech w-100 py-3 font-heading fw-bold fs-6">
                                <i class="bi bi-play-circle-fill me-2"></i> Launch Classroom Player
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- Embedded Lead Capture Form (BOFU Conversion) -->
                        <form id="courseEnrollForm" action="<?= Url::to('/submit-form') ?>" method="POST" class="space-y-3">
                            <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                            <input type="hidden" name="form_type" value="course_landing_page">
                            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">

                            <div class="mb-2">
                                <label class="form-label text-slate-800 fw-semibold small">Full Name *</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Rahul Sharma" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-slate-800 fw-semibold small">Email Address *</label>
                                <input type="email" name="email" class="form-control" placeholder="rahul@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-slate-800 fw-semibold small">Phone / WhatsApp Number *</label>
                                <input type="tel" name="phone" class="form-control" placeholder="+91 98765 43210" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-slate-800 fw-semibold small">Learning Mode Preference</label>
                                <select name="learning_tier" class="form-select">
                                    <option value="live_cohort">Live Cohort + Mentorship (₹25k - ₹40k)</option>
                                    <option value="self_paced">Self-Paced Recorded Tier (₹8k - ₹15k)</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary-edtech w-100 py-3 font-heading fw-bold fs-6">
                                Apply & Get Instant Syllabus PDF <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                            <div class="text-center text-slate-500 font-monospace" style="font-size:11px; margin-top:8px;">Instant Lead Confirmation & Counselor Call</div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================================================== -->
<!-- MOFU (MIDDLE OF FUNNEL): PAIN POINT vs SOLUTION -->
<!-- ==================================================== -->
<?php
$highlights = !empty($course['highlights_json']) ? json_decode($course['highlights_json'], true) : [];

$secTitle = $highlights['section_title'] ?? 'Why Traditional Marketing Courses Fail in 2026';
$tradTitle = $highlights['traditional_title'] ?? 'Traditional Coaching Institutes';
$blueTitle = $highlights['blueprint_title'] ?? 'The Tyche Executive Blueprint';

$tradPoints = !empty($highlights['traditional_points']) ? $highlights['traditional_points'] : [
    'Ignore AI Search (Google AI Overviews, ChatGPT, Perplexity citations).',
    'Skip DV360 & Programmatic Advertising or lock it behind ₹1,00,000+ PG fees.',
    'Teach generic dummy websites with zero real ad spend.',
    'Unverified paper certificates with zero digital validation.'
];

$bluePoints = !empty($highlights['blueprint_points']) ? $highlights['blueprint_points'] : [
    'AEO & GEO Mastery: Optimizing content for LLM crawlers & zero-click search.',
    'DV360 Programmatic: First-party data, DSP/SSP, and CTV/OTT media buying.',
    'BOS Center Case Studies: Real client performance metrics & ad account audits.',
    'SHA-256 Certificates: Cryptographically signed digital credentials with instant QR lookup.'
];
?>
<section class="py-5 bg-white border-top border-bottom border-slate-200">
    <div class="container py-4">
        <div class="text-center max-w-2xl mx-auto mb-5" style="max-width: 720px;">
            <span class="badge-pill-accent mb-2">INDUSTRY REALITY</span>
            <h2 class="display-6 font-heading fw-bold text-slate-900"><?= Security::e($secTitle) ?></h2>
            <p class="text-slate-600">Generic textbook courses focus on outdated tactics. Tyche's blueprint is engineered around real client media spend, AI search engines, and programmatic ad buying.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card-edtech p-4 h-100 bg-slate-50 border-slate-200">
                    <h4 class="h5 font-heading text-danger fw-bold mb-3"><i class="bi bi-x-circle-fill me-2"></i> <?= Security::e($tradTitle) ?></h4>
                    <ul class="list-unstyled space-y-3 text-slate-600 small">
                        <?php foreach ($tradPoints as $tp): ?>
                            <li class="mb-2"><i class="bi bi-x text-danger me-2 fs-5"></i> <?= Security::e($tp) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-edtech p-4 h-100 bg-primary-light border-primary">
                    <h4 class="h5 font-heading text-primary fw-bold mb-3"><i class="bi bi-check-circle-fill me-2"></i> <?= Security::e($blueTitle) ?></h4>
                    <ul class="list-unstyled space-y-3 text-slate-800 small">
                        <?php foreach ($bluePoints as $bp): ?>
                            <li class="mb-2"><i class="bi bi-check-lg text-primary me-2 fs-5 fw-bold"></i> <?= Security::e($bp) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ==================================================== -->
<!-- MOFU: DEEP 4-MODULE ACADEMIC SYLLABUS ACCORDION -->
<!-- ==================================================== -->
<section id="syllabus" class="py-5 bg-slate-50">
    <div class="container py-4">
        <div class="text-center max-w-2xl mx-auto mb-5" style="max-width: 720px;">
            <span class="badge-pill-accent mb-2">COMPLETE 4-MODULE SYLLABUS</span>
            <h2 class="display-6 font-heading fw-bold text-slate-900">Academic Hierarchy & Topics</h2>
            <p class="text-slate-600">Every module culminates in a real-world Capstone Project to build your professional portfolio.</p>
        </div>

        <div class="max-w-4xl mx-auto" style="max-width: 900px;">
            <div class="accordion space-y-3" id="courseHierarchyAccordion">
                <?php foreach ($hierarchy as $mIdx => $mod): ?>
                    <div class="accordion-item card-edtech border-slate-200 mb-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button bg-white text-slate-900 font-heading fw-bold py-3 fs-6 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modCollapseLanding<?= $mod['id'] ?>">
                                <span class="badge bg-primary text-white font-monospace me-3">MODULE <?= $mIdx + 1 ?></span>
                                <?= Security::e($mod['title']) ?>
                            </button>
                        </h2>
                        <div id="modCollapseLanding<?= $mod['id'] ?>" class="accordion-collapse collapse p-4 bg-white border-top">
                            <?php foreach ($mod['chapters'] as $cIdx => $chap): ?>
                                <div class="border-start border-primary border-3 ps-3 mb-4">
                                    <div class="fw-bold text-slate-900 small font-heading mb-2"><i class="bi bi-bookmark-fill text-primary me-1"></i> Chapter <?= $cIdx + 1 ?>: <?= Security::e($chap['title']) ?></div>
                                    <div class="space-y-2">
                                        <?php foreach ($chap['lessons'] as $les): ?>
                                            <div class="d-flex justify-content-between align-items-center bg-slate-50 p-3 rounded-3 border border-slate-200 mb-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-play-circle-fill text-primary fs-5"></i>
                                                    <div>
                                                        <span class="fw-semibold text-slate-900 small d-block"><?= Security::e($les['title']) ?></span>
                                                        <span class="font-monospace text-slate-500" style="font-size:11px;"><?= $les['duration_minutes'] ?> mins • <?= strtoupper($les['content_type']) ?></span>
                                                    </div>
                                                </div>
                                                <?php if ($isEnrolled || $les['is_preview']): ?>
                                                    <a href="<?= Url::to('/courses/' . $course['slug'] . '/learn/' . $les['id']) ?>" class="btn btn-outline-edtech btn-sm py-1 px-3" style="font-size:12px;"><i class="bi bi-play-fill me-1"></i> Watch Preview</a>
                                                <?php else: ?>
                                                    <span class="badge bg-slate-200 text-slate-600 font-monospace" style="font-size:11px;"><i class="bi bi-lock-fill me-1"></i> Enrolled Only</span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ==================================================== -->
<!-- MOFU: TOOLS & TECH STACK GRID -->
<!-- ==================================================== -->
<section class="py-5 bg-white">
    <div class="container py-4 text-center">
        <span class="badge-pill-accent mb-2">INDUSTRY STACK</span>
        <h2 class="display-6 font-heading fw-bold text-slate-900 mb-4">Tools & Technologies Covered</h2>
        
        <div class="row row-cols-2 row-cols-md-4 g-3 max-w-4xl mx-auto" style="max-width: 800px;">
            <div class="col">
                <div class="p-3 bg-slate-50 rounded-3 border border-slate-200 fw-bold font-heading text-slate-900">
                    <i class="bi bi-google text-danger me-2"></i> Google Ads
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-slate-50 rounded-3 border border-slate-200 fw-bold font-heading text-slate-900">
                    <i class="bi bi-meta text-primary me-2"></i> Meta Advantage+
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-slate-50 rounded-3 border border-slate-200 fw-bold font-heading text-slate-900">
                    <i class="bi bi-display text-info me-2"></i> DV360 Programmatic
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-slate-50 rounded-3 border border-slate-200 fw-bold font-heading text-slate-900">
                    <i class="bi bi-cpu text-success me-2"></i> ChatGPT & Perplexity
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-slate-50 rounded-3 border border-slate-200 fw-bold font-heading text-slate-900">
                    <i class="bi bi-graph-up text-warning me-2"></i> GA4 & GTM
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-slate-50 rounded-3 border border-slate-200 fw-bold font-heading text-slate-900">
                    <i class="bi bi-search text-primary me-2"></i> SEMrush & Schema
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-slate-50 rounded-3 border border-slate-200 fw-bold font-heading text-slate-900">
                    <i class="bi bi-kanban text-secondary me-2"></i> CRM Sales Pipelines
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-slate-50 rounded-3 border border-slate-200 fw-bold font-heading text-slate-900">
                    <i class="bi bi-code-slash text-dark me-2"></i> GTM Pixel Debugging
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================================================== -->
<!-- BOFU (BOTTOM OF FUNNEL): TWO-TIER PRICING & CONVERSION -->
<!-- ==================================================== -->
<section id="pricing" class="py-5 bg-slate-100">
    <div class="container py-4">
        <div class="text-center max-w-2xl mx-auto mb-5" style="max-width: 720px;">
            <span class="badge-pill-accent mb-2">TRANSPARENT PRICING</span>
            <h2 class="display-6 font-heading fw-bold text-slate-900">Enrollment Options & Tiers</h2>
            <p class="text-slate-600">Choose the self-paced recorded track or join our live mentorship cohort with project reviews and placement support.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Self-Paced Tier -->
            <div class="col-lg-5">
                <div class="card-edtech h-100 p-5 bg-white border-slate-200">
                    <span class="badge bg-secondary-subtle text-secondary font-monospace px-3 py-2 rounded-pill mb-3">SELF-PACED TIER</span>
                    <h3 class="h3 font-heading fw-bold text-slate-900 mb-2">Self-Paced Recorded Track</h3>
                    <p class="text-slate-600 small mb-4">Learn at your own pace with lifetime video access.</p>
                    
                    <div class="d-flex align-items-baseline gap-2 mb-4">
                        <span class="display-5 font-heading fw-bold text-slate-900">₹ <?= number_format((float)$course['price'], 0) ?></span>
                        <?php if (!empty($course['discount_price'])): ?>
                            <span class="text-slate-400 text-decoration-line-through font-monospace fs-5">₹ <?= number_format((float)$course['discount_price'], 0) ?></span>
                        <?php endif; ?>
                    </div>

                    <ul class="list-unstyled space-y-3 text-slate-700 small mb-5">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Full HD Video Access to All 4 Modules</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> AEO & GEO AI-Search Optimization</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> DV360 Programmatic Advertising Walkthrough</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Student Community Access</li>
                    </ul>

                    <a href="<?= Url::to('/courses/' . $course['slug'] . '/checkout?tier=self_paced') ?>" class="btn btn-outline-edtech w-100 py-3 font-heading fw-bold">
                        Enroll & Buy Self-Paced Track <i class="bi bi-credit-card-2-front ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Live Cohort Tier -->
            <div class="col-lg-5">
                <div class="card-edtech h-100 p-5 bg-white border-primary shadow-lg position-relative">
                    <span class="position-absolute top-0 end-0 translate-middle-y me-4 badge bg-primary text-white font-monospace px-3 py-2 rounded-pill">RECOMMENDED</span>
                    <span class="badge bg-primary-subtle text-primary font-monospace px-3 py-2 rounded-pill mb-3">LIVE COHORT + MENTORSHIP</span>
                    <h3 class="h3 font-heading fw-bold text-slate-900 mb-2">Live Cohort + Mentorship</h3>
                    <p class="text-slate-600 small mb-4">Live weekend interactive classes, project reviews, and direct placement support.</p>
                    
                    <div class="d-flex align-items-baseline gap-2 mb-4">
                        <?php $liveFee = (float)($course['live_cohort_price'] ?? ($course['price'] * 3)); ?>
                        <span class="display-5 font-heading fw-bold text-primary">₹ <?= number_format($liveFee, 0) ?></span>
                        <?php if (!empty($course['discount_price'])): ?>
                            <span class="text-slate-400 text-decoration-line-through font-monospace fs-5">₹ <?= number_format((float)($course['discount_price'] * 2.5), 0) ?></span>
                        <?php endif; ?>
                    </div>

                    <ul class="list-unstyled space-y-3 text-slate-700 small mb-5">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <strong>Everything in Self-Paced, plus:</strong></li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Live Weekend Interactive Classes & Q&A</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Capstone Project Review by Instructors</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <strong>BOS Center Real Client Case Studies</strong></li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> <strong>Verified Digital Certificate (SHA-256 Hash)</strong></li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Placement Cell & Hiring Partner Referrals</li>
                    </ul>

                    <a href="<?= Url::to('/courses/' . $course['slug'] . '/checkout?tier=live_cohort') ?>" class="btn btn-primary-edtech w-100 py-3 font-heading fw-bold">
                        Enroll & Buy Live Mentorship Cohort <i class="bi bi-credit-card-2-front ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


