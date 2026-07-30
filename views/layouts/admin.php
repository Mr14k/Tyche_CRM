<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Security::e($pageTitle ?? 'Tyche Platform') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --bg: #0F1620;
            --bg-elevated: #161F2B;
            --gold: #B98B3E;
            --gold-bright: #D9AE68;
            --parchment: #F3EEE2;
            --parchment-dim: #C9C2B2;
            --verdigris: #4B7A72;
            --line: rgba(243,238,226,0.14);
        }
        body {
            background-color: var(--bg);
            color: var(--parchment);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: var(--bg-elevated);
            border-right: 1px solid var(--line);
            position: fixed;
            top: 0; bottom: 0; left: 0;
            padding: 20px 16px;
            overflow-y: auto;
            z-index: 100;
        }
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .top-navbar {
            height: 70px;
            border-bottom: 1px solid var(--line);
            background: rgba(22,31,43,0.85);
            backdrop-filter: blur(10px);
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0; z-index: 90;
        }
        .brand-link {
            font-family: 'Fraunces', serif;
            font-size: 20px;
            color: var(--parchment);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 16px;
            margin-bottom: 12px;
            border-bottom: 1px solid var(--line);
        }
        .nav-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--verdigris);
            margin: 14px 10px 6px;
            font-weight: 600;
        }
        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            color: var(--parchment-dim);
            text-decoration: none;
            border-radius: 4px;
            font-size: 13.5px;
            transition: all 0.2s;
        }
        .nav-item-link:hover, .nav-item-link.active {
            background: rgba(185,139,62,0.12);
            color: var(--gold-bright);
        }
        .content-body {
            padding: 32px;
            flex: 1;
        }
        .card-custom {
            background: var(--bg-elevated);
            border: 1px solid var(--line);
            border-radius: 6px;
        }
        .table-custom {
            color: var(--parchment);
        }
        .table-custom th {
            background: #0F1620 !important;
            color: var(--gold-bright) !important;
            font-weight: 600;
            border-bottom: 1px solid var(--line) !important;
            font-size: 13px;
        }
        .table-custom td {
            border-bottom: 1px solid var(--line) !important;
            vertical-align: middle;
            font-size: 14px;
            color: var(--parchment) !important;
            background: #161F2B !important;
        }

        /* Bootstrap Dark Table & Card Contrast Overrides */
        .table:not(.bg-white .table), table:not(.bg-white table) {
            --bs-table-bg: #161F2B !important;
            --bs-table-color: #F3EEE2 !important;
            --bs-table-hover-bg: #1E293B !important;
            --bs-table-hover-color: #FFFFFF !important;
            --bs-table-striped-bg: #111822 !important;
            --bs-table-striped-color: #F3EEE2 !important;
            --bs-table-border-color: rgba(243,238,226,0.14) !important;
            color: #F3EEE2 !important;
            background-color: #161F2B !important;
        }

        .card-custom {
            background-color: #161F2B !important;
            border: 1px solid rgba(243,238,226,0.14) !important;
            color: #F3EEE2 !important;
        }

        .card:not(.bg-white) {
            background-color: #161F2B !important;
            border: 1px solid rgba(243,238,226,0.14) !important;
            color: #F3EEE2 !important;
        }

        /* Explicit Light Container & Invoice Styling */
        .bg-white {
            background-color: #FFFFFF !important;
            color: #0F172A !important;
        }

        .bg-white .table th {
            background-color: #0F172A !important;
            color: #FFFFFF !important;
        }

        .bg-white .table td {
            background-color: #FFFFFF !important;
            color: #0F172A !important;
            border-color: #CBD5E1 !important;
        }

        /* High-Contrast Form Labels, Inputs & Placeholders for Dark Theme */
        .form-label, label {
            color: #D9AE68 !important; /* High-contrast gold / warm amber */
            font-weight: 600;
            font-size: 0.88rem;
            margin-bottom: 0.35rem;
        }

        .text-muted:not(.bg-white *), .text-secondary:not(.bg-white *) {
            color: #CBD5E1 !important; /* Crisp light slate / parchment */
        }

        .modal-content:not(.bg-white) {
            background-color: #161F2B !important;
            border: 1px solid rgba(243,238,226,0.2) !important;
            color: #F3EEE2 !important;
        }

        .modal-header, .modal-footer {
            border-color: rgba(243,238,226,0.14) !important;
        }

        .form-control, .form-select, select, textarea {
            background-color: #0F1620 !important;
            color: #F3EEE2 !important;
            border: 1px solid rgba(243,238,226,0.25) !important;
        }

        .form-control::placeholder, textarea::placeholder {
            color: #94A3B8 !important; /* Bright legible slate placeholder */
            opacity: 1 !important;
        }

        .form-select option {
            background-color: #0F1620 !important;
            color: #F3EEE2 !important;
        }

        .form-control:focus, .form-select:focus {
            background-color: #0F1620 !important;
            color: #FFFFFF !important;
            border-color: #B98B3E !important;
            box-shadow: 0 0 0 0.25rem rgba(185, 139, 62, 0.3) !important;
        }

        .text-light {
            color: #F3EEE2 !important;
        }

        .text-dark:not(.bg-white *) {
            color: #F8FAFC !important;
        }

        .badge-light:not(.bg-white *) {
            background-color: #0F1620 !important;
            color: #E2E8F0 !important;
            border: 1px solid rgba(243,238,226,0.2) !important;
        }


        .btn-gold {
            background: var(--gold);
            color: var(--bg);
            font-weight: 600;
            border: none;
        }
        .btn-gold:hover {
            background: var(--gold-bright);
            color: var(--bg);
        }

        .search-box {
            position: relative;
            width: 320px;
        }
        .search-box input {
            background: #0F1620;
            border: 1px solid var(--line);
            color: var(--parchment);
            border-radius: 20px;
            padding: 6px 16px 6px 36px;
            font-size: 13px;
            width: 100%;
        }
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--verdigris);
        }
        .search-results-dropdown {
            position: absolute;
            top: 42px; left: 0; right: 0;
            background: var(--bg-elevated);
            border: 1px solid var(--line);
            border-radius: 6px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 200;
            display: none;
        }
        .search-results-dropdown a {
            display: block;
            padding: 10px 14px;
            color: var(--parchment);
            text-decoration: none;
            border-bottom: 1px solid var(--line);
            font-size: 13px;
        }
        .search-results-dropdown a:hover {
            background: rgba(185,139,62,0.1);
            color: var(--gold-bright);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php
            $brandHome = Url::to('/dashboard');
            if (!\App\Services\RbacService::hasRole('Admin')) {
                if (\App\Services\RbacService::hasPermission('STUDENT.Portal')) {
                    $brandHome = Url::to('/student/dashboard');
                } elseif (\App\Services\RbacService::hasPermission('FACULTY.Workspace')) {
                    $brandHome = Url::to('/faculty/dashboard');
                }
            }
        ?>
        <a href="<?= $brandHome ?>" class="brand-link">
            <svg width="28" height="28" viewBox="0 0 40 40" fill="none">
                <circle cx="20" cy="20" r="18" stroke="#B98B3E" stroke-width="1.4"/>
                <circle cx="20" cy="20" r="3" fill="#B98B3E"/>
                <path d="M20 4V13M20 27V36M4 20H13M27 20H36" stroke="#B98B3E" stroke-width="1.2"/>
            </svg>
            Tyche
        </a>
        
        <?php if (\App\Services\RbacService::hasRole('Admin')): ?>
            <div class="nav-label">Executive Command</div>
            <a href="<?= Url::to('/dashboard') ?>" class="nav-item-link <?= $_SERVER['REQUEST_URI'] === Url::to('/dashboard') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Telemetry Overview
            </a>
            <?php if (($_SESSION['user']['tenant_id'] ?? 1) === 1): ?>
                <a href="<?= Url::to('/admin/tenants') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/tenants') ? 'active' : '' ?>">
                    <i class="bi bi-building"></i> SaaS Pilot Academies
                </a>
            <?php endif; ?>
            <?php if (\App\Services\RbacService::hasPermission('BI.ViewReports') && \App\Services\PlanFeatureService::hasModuleAccess('bi')): ?>
                <a href="<?= Url::to('/admin/bi/dashboard') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/bi/dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-graph-up-arrow"></i> Executive BI Telemetry
                </a>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('STUDENT.Portal')): ?>
            <div class="nav-label">Student Classroom</div>
            <a href="<?= Url::to('/student/dashboard') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/student/dashboard') ? 'active' : '' ?>">
                <i class="bi bi-laptop"></i> Digital Classroom
            </a>
            <a href="<?= Url::to('/student/assignments') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/student/assignments') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-check"></i> Assignments Hub
            </a>
            <a href="<?= Url::to('/student/certificates') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/student/certificates') ? 'active' : '' ?>">
                <i class="bi bi-award-fill"></i> My Certificates
            </a>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('FACULTY.Workspace')): ?>
            <div class="nav-label">Faculty Workspace</div>
            <a href="<?= Url::to('/faculty/dashboard') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/faculty/dashboard') ? 'active' : '' ?>">
                <i class="bi bi-person-workspace"></i> Instructor Desk
            </a>
            <a href="<?= Url::to('/faculty/assignments') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/faculty/assignments') ? 'active' : '' ?>">
                <i class="bi bi-check-all"></i> Grade Submissions
            </a>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('PLACEMENT.ManageJobs') && \App\Services\PlanFeatureService::hasModuleAccess('placement')): ?>
            <div class="nav-label">Placement & Career</div>
            <a href="<?= Url::to('/admin/placement/jobs') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/placement/jobs') ? 'active' : '' ?>">
                <i class="bi bi-briefcase-fill"></i> Job Openings Board
            </a>
            <a href="<?= Url::to('/admin/placement/applications') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/placement/applications') ? 'active' : '' ?>">
                <i class="bi bi-person-lines-fill"></i> Student Applications
            </a>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('AUTOMATION.ManageCampaigns') && \App\Services\PlanFeatureService::hasModuleAccess('automation')): ?>
            <div class="nav-label">Marketing Automation</div>
            <a href="<?= Url::to('/admin/automation/campaigns') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/automation/campaigns') ? 'active' : '' ?>">
                <i class="bi bi-megaphone-fill"></i> Campaigns & Referrals
            </a>
            <a href="<?= Url::to('/admin/automation/coupons') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/automation/coupons') ? 'active' : '' ?>">
                <i class="bi bi-ticket-perforated-fill"></i> Discount Coupons
            </a>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('SYSTEM.AdminConsole')): ?>
            <div class="nav-label">System Administration</div>
            <a href="<?= Url::to('/admin/system/console') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/system/console') ? 'active' : '' ?>">
                <i class="bi bi-sliders"></i> Admin Console & Cache
            </a>
            <a href="<?= Url::to('/admin/system/backups') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/system/backups') ? 'active' : '' ?>">
                <i class="bi bi-database-fill-down"></i> Database Backups
            </a>
            <a href="<?= Url::to('/admin/system/health') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/system/health') ? 'active' : '' ?>">
                <i class="bi bi-cpu-fill"></i> System Health Logs
            </a>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('CRM.ViewLeads') && \App\Services\PlanFeatureService::hasModuleAccess('crm')): ?>
            <div class="nav-label">CRM & Admissions</div>
            <a href="<?= Url::to('/admin/crm/leads') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/crm/leads') ? 'active' : '' ?>">
                <i class="bi bi-funnel-fill"></i> Leads Sales Pipeline
            </a>
            <a href="<?= Url::to('/admin/crm/batches') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/crm/batches') ? 'active' : '' ?>">
                <i class="bi bi-calendar-event"></i> Academic Batches
            </a>
            <a href="<?= Url::to('/admin/crm/counselor') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/crm/counselor') ? 'active' : '' ?>">
                <i class="bi bi-headset"></i> Counselor Desk & Demos
            </a>
        <?php endif; ?>


        <?php if (\App\Services\RbacService::hasPermission('FINANCE.ViewPayments') && \App\Services\PlanFeatureService::hasModuleAccess('finance')): ?>
            <div class="nav-label">Payments & Finance</div>
            <a href="<?= Url::to('/admin/finance/payments') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/finance/payments') ? 'active' : '' ?>">
                <i class="bi bi-currency-rupee"></i> Payment Transactions
            </a>
            <a href="<?= Url::to('/admin/finance/invoices') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/finance/invoices') ? 'active' : '' ?>">
                <i class="bi bi-receipt-cutoff"></i> 18% GST Tax Invoices
            </a>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('COMMUNICATION.SendBroadcast')): ?>
            <div class="nav-label">Communication Hub</div>
            <a href="<?= Url::to('/admin/communication/hub') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/communication/hub') ? 'active' : '' ?>">
                <i class="bi bi-broadcast-pin"></i> Broadcast & Templates
            </a>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('LMS.ViewCourses')): ?>
            <div class="nav-label">Academic LMS Core</div>
            <a href="<?= Url::to('/admin/lms/courses') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/lms/courses') ? 'active' : '' ?>">
                <i class="bi bi-journal-bookmark-fill"></i> Courses & Hierarchy
            </a>
            <a href="<?= Url::to('/admin/lms/enrollments') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/lms/enrollments') ? 'active' : '' ?>">
                <i class="bi bi-mortarboard"></i> Student Enrollments
            </a>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('CMS.ViewPages')): ?>
            <div class="nav-label">Website CMS</div>
            <a href="<?= Url::to('/admin/cms/pages') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/cms/pages') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text"></i> Pages Builder
            </a>
            <a href="<?= Url::to('/admin/blog') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/blog') ? 'active' : '' ?>">
                <i class="bi bi-newspaper"></i> Blog Article Publisher
            </a>
            <a href="<?= Url::to('/admin/cms/menus') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/cms/menus') ? 'active' : '' ?>">
                <i class="bi bi-menu-button-wide"></i> Navigation Menus
            </a>

            <a href="<?= Url::to('/admin/cms/banners') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/cms/banners') ? 'active' : '' ?>">
                <i class="bi bi-images"></i> Banners & Sliders
            </a>
            <a href="<?= Url::to('/admin/cms/faculty') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/cms/faculty') ? 'active' : '' ?>">
                <i class="bi bi-person-workspace"></i> Faculty Showcase
            </a>
            <a href="<?= Url::to('/admin/cms/media') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/cms/media') ? 'active' : '' ?>">
                <i class="bi bi-folder-symlink"></i> Media Library
            </a>
            <a href="<?= Url::to('/admin/cms/settings') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/cms/settings') ? 'active' : '' ?>">
                <i class="bi bi-sliders"></i> Global Site Settings
            </a>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasRole('Admin')): ?>
            <div class="nav-label">User Administration</div>
            <a href="<?= Url::to('/admin/users') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/users') ? 'active' : '' ?>">
                <i class="bi bi-people"></i> User Management
            </a>
            <a href="<?= Url::to('/admin/roles') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/roles') ? 'active' : '' ?>">
                <i class="bi bi-shield-lock"></i> Roles & Permissions
            </a>
        <?php endif; ?>

        <div class="nav-label">User Account</div>
        <a href="<?= Url::to('/account/profile') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/account/profile') ? 'active' : '' ?>">
            <i class="bi bi-person-gear"></i> Profile & Settings
        </a>
        <a href="<?= Url::to('/jobs') ?>" class="nav-item-link text-info" target="_blank">
            <i class="bi bi-briefcase-fill"></i> Public Placement Board
        </a>
        <a href="<?= Url::to('/courses') ?>" class="nav-item-link text-warning" target="_blank">
            <i class="bi bi-play-circle-fill"></i> LMS Student Catalog
        </a>
        <a href="<?= Url::to('/') ?>" class="nav-item-link" target="_blank">
            <i class="bi bi-globe"></i> View Website <i class="bi bi-box-arrow-up-right ms-auto"></i>
        </a>
    </div>

    <div class="main-wrapper">
        <div class="top-navbar">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="globalSearchInput" placeholder="Search courses, blogs, users, leads, invoices..." autocomplete="off">
                <div class="search-results-dropdown" id="searchResultsDropdown"></div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <?php 
                    $currUser = \App\Core\Session::get('user'); 
                    $notifService = new \App\Services\NotificationService();
                    $unreadCount = $notifService->getUnreadCount((int)$currUser['id']);
                ?>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm position-relative" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <?php if ($unreadCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:10px;"><?= $unreadCount ?></span>
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg" style="width:320px; background:#161F2B; border:1px solid rgba(243,238,226,0.14); color:#F3EEE2;">
                        <div class="p-3 border-bottom border-secondary d-flex justify-content-between align-items-center">
                            <span class="fw-bold small">System Notifications</span>
                            <span class="badge bg-warning text-dark font-monospace" style="font-size:10px;"><?= $unreadCount ?> New</span>
                        </div>
                        <div style="max-height:250px; overflow-y:auto;">
                            <?php 
                                $userNotifs = $notifService->getUserNotifications((int)$currUser['id']);
                                if (empty($userNotifs)): 
                            ?>
                                <div class="p-3 text-center text-muted small">No notifications.</div>
                            <?php else: ?>
                                <?php foreach (array_slice($userNotifs, 0, 5) as $n): ?>
                                    <a href="<?= Url::to($n['action_url'] ?? '/dashboard') ?>" class="dropdown-item text-light border-bottom border-secondary p-3 small" style="white-space:normal;">
                                        <div class="fw-bold text-warning"><?= Security::e($n['title']) ?></div>
                                        <div class="text-secondary small mt-1"><?= Security::e($n['message']) ?></div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="text-end me-2 d-none d-sm-block">
                    <div class="fw-semibold text-light small"><?= Security::e($currUser['first_name'] . ' ' . $currUser['last_name']) ?></div>
                    <div class="text-muted" style="font-size: 11px;"><?= Security::e(implode(', ', $currUser['roles'] ?? ['User'])) ?></div>
                </div>

                <form action="<?= Url::to('/logout') ?>" method="POST" class="m-0">
                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="content-body">
            <?= \App\Helpers\Flash::render() ?>
            <?= $content ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const searchInput = document.getElementById('globalSearchInput');
        const searchDropdown = document.getElementById('searchResultsDropdown');

        if (searchInput) {
            let timeout = null;
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                const query = this.value.trim();
                if (query.length < 2) {
                    searchDropdown.style.display = 'none';
                    return;
                }
                timeout = setTimeout(() => {
                    fetch('<?= Url::to('/admin/search') ?>?q=' + encodeURIComponent(query))
                        .then(r => r.json())
                        .then(data => {
                            if (data.results && data.results.length > 0) {
                                let html = '';
                                data.results.forEach(res => {
                                    html += `<a href="${res.url}"><i class="bi ${res.icon} me-2 text-warning"></i><strong class="text-info">${res.type}:</strong> ${res.title}</a>`;
                                });
                                searchDropdown.innerHTML = html;
                                searchDropdown.style.display = 'block';
                            } else {
                                searchDropdown.innerHTML = '<div class="p-3 text-muted small text-center">No matching results found.</div>';
                                searchDropdown.style.display = 'block';
                            }
                        });
                }, 250);
            });

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                    searchDropdown.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
