<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= Security::e($pageTitle ?? 'Tyche — Digital Marketing Academy | SEO, AEO, GEO & Programmatic Mastery 2026') ?></title>
    
    <!-- SEO Meta Tags & Targeted Keywords -->
    <meta name="description" content="India's leading Digital Marketing Academy offering 4-Module Executive Mastery in SEO, AEO (Answer Engine), GEO (Generative AI Search), Meta Advantage+ Performance Ads, and DV360 Programmatic Buying. Guaranteed Placement Support.">
    <meta name="keywords" content="Digital Marketing Course India, Digital Marketing Academy, SEO AEO GEO Course 2026, Answer Engine Optimization, Generative Engine Optimization, DV360 Programmatic Advertising Institute, Meta Advantage Performance Ads, Performance Marketing Certification, Google Ads Training, AI Search Engine Optimization, GTM Server Side Tracking, Marketing Funnels TOFU MOFU BOFU">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="author" content="Tyche Digital Marketing Academy">
    
    <!-- OpenGraph & Social Schema -->
    <meta property="og:title" content="<?= Security::e($pageTitle ?? 'Tyche — Digital Marketing Academy | SEO, AEO, GEO & DV360 Mastery') ?>">
    <meta property="og:description" content="Master SEO, AEO, GEO, Meta Ads & DV360 Programmatic Buying with real BOS Center client case studies and verified SHA-256 certificates.">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Tyche Academy">
    <meta property="og:locale" content="en_IN">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= Security::e($pageTitle ?? 'Tyche Digital Marketing Academy') ?>">
    <meta name="twitter:description" content="Learn SEO, AEO, GEO AI Search, Performance Ads & DV360 Programmatic Buying.">

    <!-- Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --primary-light: #EEF2FF;
            --secondary: #0284C7;
            --accent: #10B981;
            --amber: #F59E0B;
            --rose: #F43F5E;
            --slate-900: #0F172A;
            --slate-800: #1E293B;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-500: #64748B;
            --slate-100: #F1F5F9;
            --slate-50: #F8FAFC;
            --border: #E2E8F0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --font-heading: 'Outfit', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--slate-50);
            color: var(--slate-800);
            font-family: var(--font-body);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: var(--font-heading);
            color: var(--slate-900);
            font-weight: 700;
        }

        /* Top Bar */
        .announcement-bar {
            background: linear-gradient(90deg, #4338CA 0%, #0284C7 100%);
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 0;
        }

        /* Modern EdTech Navbar */
        .navbar-edtech {
            background: #FFFFFF;
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand-text {
            font-family: var(--font-heading);
            font-size: 24px;
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.02em;
        }

        .navbar-brand-text span {
            color: var(--primary);
        }

        .nav-link-edtech {
            color: var(--slate-700);
            font-weight: 600;
            font-size: 15px;
            padding: 8px 16px !important;
            transition: all 0.2s ease;
        }

        .nav-link-edtech:hover {
            color: var(--primary);
        }

        .btn-primary-edtech {
            background-color: var(--primary);
            color: #FFFFFF;
            font-weight: 700;
            font-size: 14px;
            padding: 10px 24px;
            border-radius: 50px;
            border: none;
            box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.35);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary-edtech:hover {
            background-color: var(--primary-dark);
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px 0 rgba(79, 70, 229, 0.45);
        }

        .btn-outline-edtech {
            background-color: transparent;
            color: var(--slate-800);
            border: 2px solid var(--border);
            font-weight: 700;
            font-size: 14px;
            padding: 10px 24px;
            border-radius: 50px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-outline-edtech:hover {
            border-color: var(--primary);
            color: var(--primary);
            background-color: var(--primary-light);
        }

        /* Hero Light Section */
        .hero-light {
            background: radial-gradient(100% 100% at 50% 0%, #EEF2FF 0%, #F8FAFC 100%);
            padding: 70px 0 80px;
            border-bottom: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .badge-pill-accent {
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid rgba(79, 70, 229, 0.2);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .card-edtech {
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .card-edtech:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-3px);
            border-color: rgba(79, 70, 229, 0.3);
        }

        /* Mobile Responsiveness Overrides */
        @media (max-width: 991.98px) {
            .navbar-edtech .navbar-collapse {
                background: #FFFFFF;
                padding: 20px;
                border-radius: 16px;
                box-shadow: var(--shadow-lg);
                margin-top: 12px;
                border: 1px solid var(--border);
            }
            .hero-light {
                padding: 40px 0 50px;
            }
            .display-4 {
                font-size: 2.25rem !important;
            }
            .display-5 {
                font-size: 1.85rem !important;
            }
            .display-6 {
                font-size: 1.6rem !important;
            }
            .card-edtech {
                padding: 24px !important;
            }
        }

        @media (max-width: 575.98px) {
            .announcement-bar {
                font-size: 11px;
            }
            .btn-primary-edtech, .btn-outline-edtech {
                width: 100% !important;
                margin-bottom: 8px;
            }
            .hero-light {
                padding: 30px 0 40px;
            }
            .table-responsive {
                font-size: 13px;
            }
        }

        /* Footer Light */
        .footer-edtech {
            background: #FFFFFF;
            border-top: 1px solid var(--border);
            color: var(--slate-600);
            padding: 70px 0 30px;
            font-size: 14px;
        }

        .footer-heading {
            font-family: var(--font-heading);
            color: var(--slate-900);
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--slate-600);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }
    </style>

    <!-- Schema JSON-LD for Digital Marketing Academy -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "Tyche Digital Marketing Academy",
      "url": "https://tyche.academy",
      "logo": "https://tyche.academy/assets/logo.png",
      "description": "India's leading EdTech academy for Digital Marketing Mastery, SEO, AEO, GEO, Meta Ads & DV360 Programmatic Advertising.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Innovation Tower, Cyber City",
        "addressLocality": "Gurugram",
        "addressRegion": "Haryana",
        "postalCode": "122002",
        "addressCountry": "IN"
      },
      "sameAs": [
        "https://linkedin.com",
        "https://youtube.com"
      ]
    }
    </script>
</head>
<body>

    <!-- Announcement Bar -->
    <div class="announcement-bar text-center">
        <div class="container d-flex justify-content-center align-items-center gap-2 flex-wrap">
            <span class="badge bg-white text-primary fw-bold font-monospace">NEW BATCH 2026</span>
            <span>Admissions Open for SEO, AEO, GEO & DV360 Programmatic Cohort!</span>
            <a href="#enrollModal" data-bs-toggle="modal" class="text-white text-decoration-underline ms-2 fw-bold">Claim Scholarship →</a>
        </div>
    </div>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-edtech">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= Url::to('/') ?>">
                <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-3 p-2" style="width:36px; height:36px;">
                    <i class="bi bi-mortarboard-fill fs-5"></i>
                </div>
                <span class="navbar-brand-text">Tyche<span>.</span></span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link nav-link-edtech" href="<?= Url::to('/') ?>#curriculum">4-Module Blueprint</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-edtech" href="<?= Url::to('/courses') ?>">All Courses</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-edtech" href="<?= Url::to('/jobs') ?>">Placement Cell</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-edtech" href="<?= Url::to('/blog') ?>">Blog & Insights</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-edtech" href="<?= Url::to('/contact') ?>">Contact Us</a></li>
                </ul>

                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    <?php if (\App\Core\Session::has('user')): ?>
                        <?php 
                            $u = \App\Core\Session::get('user');
                            $dashUrl = Url::to('/dashboard');
                            if (!\App\Services\RbacService::hasRole('Admin')) {
                                if (\App\Services\RbacService::hasPermission('STUDENT.Portal')) $dashUrl = Url::to('/student/dashboard');
                                elseif (\App\Services\RbacService::hasPermission('FACULTY.Workspace')) $dashUrl = Url::to('/faculty/dashboard');
                            }
                        ?>
                        <a href="<?= $dashUrl ?>" class="btn btn-primary-edtech w-100 w-lg-auto">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?= Url::to('/login') ?>" class="btn btn-outline-edtech me-2">Sign In</a>
                        <button class="btn btn-primary-edtech" data-bs-toggle="modal" data-bs-target="#enrollModal">Apply Now</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?= $content ?>
    </main>

    <!-- Modal: Instant Lead Form -->
    <div class="modal fade" id="enrollModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-primary text-white p-4">
                    <div>
                        <h5 class="modal-title font-heading fw-bold mb-1">Apply for Digital Marketing Mastery</h5>
                        <p class="small text-white-50 m-0">Get detailed course syllabus, fee structure & scholarship eligibility.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= Url::to('/submit-form') ?>" method="POST">
                    <div class="modal-body p-4">
                        <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                        <input type="hidden" name="form_type" value="course_enquiry">
                        
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold small">Full Name *</label>
                            <input type="text" name="name" class="form-control form-control-lg fs-6" placeholder="e.g. Rahul Sharma" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold small">Email Address *</label>
                            <input type="email" name="email" class="form-control form-control-lg fs-6" placeholder="rahul@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold small">Phone / WhatsApp Number *</label>
                            <input type="tel" name="phone" class="form-control form-control-lg fs-6" placeholder="+91 98765 43210" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold small">Preferred Learning Mode</label>
                            <select name="learning_tier" class="form-select form-select-lg fs-6">
                                <option value="live_cohort">Live Cohort + Mentorship Tier (₹25,000 - ₹40,000)</option>
                                <option value="self_paced">Self-Paced Recorded Tier (₹8,000 - ₹15,000)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-3 border-top">
                        <button type="submit" class="btn btn-primary-edtech w-100 py-3">Submit Application & Get Syllabus PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer Light Theme -->
    <footer class="footer-edtech">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <a class="navbar-brand d-flex align-items-center gap-2 mb-3" href="<?= Url::to('/') ?>">
                        <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-3 p-2" style="width:36px; height:36px;">
                            <i class="bi bi-mortarboard-fill fs-5"></i>
                        </div>
                        <span class="navbar-brand-text">Tyche<span>.</span></span>
                    </a>
                    <p class="text-slate-600 mb-4">Tyche Digital Marketing Academy is India's leading EdTech platform for SEO, AEO, GEO, Meta Ads & DV360 Programmatic Advertising.</p>
                    <div class="d-flex gap-3">
                        <a href="https://linkedin.com" target="_blank" class="btn btn-light btn-sm rounded-circle p-2 text-primary" aria-label="LinkedIn"><i class="bi bi-linkedin fs-5"></i></a>
                        <a href="https://youtube.com" target="_blank" class="btn btn-light btn-sm rounded-circle p-2 text-danger" aria-label="YouTube"><i class="bi bi-youtube fs-5"></i></a>
                        <a href="https://twitter.com" target="_blank" class="btn btn-light btn-sm rounded-circle p-2 text-info" aria-label="Twitter"><i class="bi bi-twitter-x fs-5"></i></a>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="footer-heading">Curriculum</h6>
                    <ul class="footer-links">
                        <li><a href="<?= Url::to('/courses/seo-aeo-geo-search-foundations') ?>">SEO, AEO & GEO</a></li>
                        <li><a href="<?= Url::to('/courses/meta-google-advertising-mastery') ?>">Meta & Google Ads</a></li>
                        <li><a href="<?= Url::to('/courses/programmatic-advertising-dv360') ?>">DV360 Programmatic</a></li>
                        <li><a href="<?= Url::to('/courses/the-apex-web-fundamentals-for-marketers') ?>">Web Fundamentals</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="footer-heading">Academy</h6>
                    <ul class="footer-links">
                        <li><a href="<?= Url::to('/courses') ?>">Course Catalog</a></li>
                        <li><a href="<?= Url::to('/jobs') ?>">Placement Cell</a></li>
                        <li><a href="<?= Url::to('/blog') ?>">Case Studies & Blog</a></li>
                        <li><a href="<?= Url::to('/contact') ?>">Contact Us</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h6 class="footer-heading">Newsletter & AI Marketing Insights</h6>
                    <p class="text-slate-600 small">Subscribe for weekly breakdown of AEO/GEO zero-click search strategies and programmatic ad media plans.</p>
                    <form action="<?= Url::to('/subscribe-newsletter') ?>" method="POST" class="mt-3">
                        <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="Enter work email" required>
                            <button class="btn btn-primary-edtech rounded-end-pill px-4" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="border-top border-slate-200 pt-4 d-flex justify-content-between align-items-center flex-wrap gap-2 text-slate-500 small">
                <div>© <?= date('Y') ?> Tyche Digital Marketing Academy. All Rights Reserved.</div>
                <div class="d-flex gap-4">
                    <a href="<?= Url::to('/privacy-policy') ?>" class="text-slate-500 text-decoration-none">Privacy Policy</a>
                    <a href="<?= Url::to('/terms-of-service') ?>" class="text-slate-500 text-decoration-none">Terms of Service</a>
                    <a href="<?= Url::to('/verify-invoice') ?>" class="text-slate-500 text-decoration-none">GST Invoice Lookup</a>
                </div>
            </div>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
