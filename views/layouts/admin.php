<?php
use App\Helpers\Url;
use App\Helpers\Security;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Security::e($pageTitle ?? 'Tyche Monolith Executive System') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= Url::to('/assets/css/tyche-modern-ui.css') ?>">
    <style>
        :root {
            --bg: #0F1620;
            --bg-elevated: #161F2B;
            --gold-bright: #D9AE68;
            --gold-muted: #B98B3E;
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
        /* Comprehensive Dark Theme Global Overrides */
        .text-muted, small.text-muted, div.text-muted, span.text-muted, td.text-muted {
            color: #CBD5E1 !important; /* High contrast light grey */
        }
        .text-secondary {
            color: #94A3B8 !important;
        }
        .text-slate-400 {
            color: #CBD5E1 !important;
        }
        .card-custom, .card {
            background-color: #161F2B !important;
            border: 1px solid var(--line) !important;
            border-radius: 12px;
            color: #F3EEE2 !important;
        }
        /* Enforce Dark Table Styling Across All Admin Modules */
        table, table.table, .table > :not(caption) > * > * {
            background-color: #161F2B !important;
            color: #F3EEE2 !important;
            border-color: rgba(243,238,226,0.08) !important;
            box-shadow: none !important;
        }
        table thead, table thead tr, table thead th, .table > thead > tr > th {
            background-color: #0F1620 !important;
            color: #D9AE68 !important;
            border-bottom: 1px solid rgba(243,238,226,0.14) !important;
        }
        table.table-hover tbody tr:hover, table.table-hover tbody tr:hover td {
            background-color: #1C2736 !important;
            color: #FFFFFF !important;
        }
        .modal-content {
            background-color: #161F2B !important;
            color: #F3EEE2 !important;
            border: 1px solid rgba(243,238,226,0.2) !important;
        }
        .modal-header, .card-header {
            background-color: #0F1620 !important;
            border-bottom: 1px solid rgba(243,238,226,0.14) !important;
        }
        .modal-footer, .card-footer {
            background-color: #0F1620 !important;
            border-top: 1px solid rgba(243,238,226,0.14) !important;
        }
        .form-control, .form-select {
            background-color: #0F1620 !important;
            color: #F8FAFC !important;
            border: 1px solid rgba(243,238,226,0.2) !important;
        }
        .form-control:focus, .form-select:focus {
            background-color: #0F1620 !important;
            color: #FFFFFF !important;
            border-color: #D9AE68 !important;
            box-shadow: 0 0 0 0.2rem rgba(217,174,104,0.25) !important;
        }
        #spa-loader-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #D9AE68, #F59E0B, #60A5FA);
            z-index: 9999;
            transition: width 0.3s ease, opacity 0.3s ease;
            opacity: 0;
            box-shadow: 0 0 10px rgba(217, 174, 104, 0.8);
        }
        #app-content {
            transition: opacity 0.15s ease-in-out;
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
        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--gold-bright);
            font-weight: 700;
            font-size: 20px;
            text-decoration: none;
            margin-bottom: 24px;
            letter-spacing: 0.05em;
        }
        .brand-link:hover { color: var(--gold-bright); }
        
        /* Collapsible Accordion Sidebar Styles */
        .nav-group-header {
            color: var(--gold-bright);
            font-size: 11px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-weight: 700;
            cursor: pointer;
            user-select: none;
            padding: 8px 10px;
            margin-top: 10px;
            margin-bottom: 2px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.2s ease, color 0.2s ease;
        }
        .nav-group-header:hover {
            background: rgba(217, 174, 104, 0.12);
            color: #FFF;
        }
        .nav-group-header .toggle-icon {
            font-size: 10px;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-group-items {
            max-height: 1000px;
            overflow: hidden;
            transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s ease;
            opacity: 1;
        }
        .nav-group.collapsed .nav-group-items {
            max-height: 0 !important;
            opacity: 0 !important;
            padding: 0 !important;
        }
        .nav-group.collapsed .toggle-icon {
            transform: rotate(-90deg);
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            color: var(--parchment-dim);
            text-decoration: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.15s ease;
            margin-bottom: 3px;
        }
        .nav-item-link:hover {
            color: var(--parchment);
            background: rgba(243,238,226,0.06);
        }
        .nav-item-link.active {
            color: #0F1620;
            background: var(--gold-bright);
            font-weight: 600;
        }
        .top-navbar {
            height: 64px;
            background: var(--bg-elevated);
            border-bottom: 1px solid var(--line);
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .content-body {
            padding: 28px 32px;
            flex: 1;
        }
        .badge-role {
            background: rgba(75,122,114,0.3);
            color: var(--parchment);
            border: 1px solid var(--verdigris);
        }
        .search-box {
            position: relative;
            width: 320px;
        }
        .search-box input {
            background: var(--bg);
            border: 1px solid var(--line);
            color: var(--parchment);
            padding-left: 36px;
            font-size: 13px;
            border-radius: 20px;
            width: 100%;
        }
        .search-box input:focus {
            background: var(--bg);
            border-color: var(--gold-bright);
            color: var(--parchment);
            box-shadow: none;
        }
        .search-box .bi-search {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--parchment-dim);
            font-size: 13px;
        }
        .search-results-dropdown {
            position: absolute;
            top: 100%;
            left: 0; right: 0;
            margin-top: 8px;
            background: var(--bg-elevated);
            border: 1px solid var(--line);
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
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

        /* High-Contrast Badges & Text Compatibility */
        .text-dark { color: #0F1620 !important; }
        .text-white { color: #FFFFFF !important; }
        .badge.bg-warning.text-dark { color: #0F1620 !important; font-weight: 700; }
    </style>
</head>
<body>
    <div id="spa-loader-bar"></div>
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
            <div class="nav-group" id="group-executive">
                <div class="nav-group-header">
                    <span><i class="bi bi-speedometer2 me-2"></i>Executive Command</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/dashboard') ?>" class="nav-item-link <?= $_SERVER['REQUEST_URI'] === Url::to('/dashboard') ? 'active' : '' ?>">
                        <i class="bi bi-speedometer2"></i> Telemetry Overview
                    </a>
                    <?php if (($_SESSION['user']['tenant_id'] ?? 1) === 1): ?>
                        <a href="<?= Url::to('/admin/saas/command-center') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/saas/command-center') ? 'active' : '' ?>" style="color: #D9AE68; font-weight: 600;">
                            <i class="bi bi-broadcast-pin text-warning"></i> SaaS Command Center
                        </a>
                        <a href="<?= Url::to('/admin/tenants') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/tenants') ? 'active' : '' ?>">
                            <i class="bi bi-building"></i> SaaS Pilot Academies
                        </a>
                        <a href="<?= Url::to('/admin/subscriptions') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/subscriptions') ? 'active' : '' ?>">
                            <i class="bi bi-credit-card-2-front"></i> SaaS Subscription Manager
                        </a>
                    <?php endif; ?>
                    <?php if (\App\Services\RbacService::hasPermission('BI.ViewReports') && \App\Services\PlanFeatureService::hasModuleAccess('bi')): ?>
                        <a href="<?= Url::to('/admin/bi/dashboard') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/bi/dashboard') ? 'active' : '' ?>">
                            <i class="bi bi-graph-up-arrow"></i> Executive BI Telemetry
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('CRM.ViewLeads') && \App\Services\PlanFeatureService::hasModuleAccess('crm')): ?>
            <div class="nav-group" id="group-crm">
                <div class="nav-group-header">
                    <span><i class="bi bi-funnel-fill me-2"></i>CRM & Admissions</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/admin/crm/leads') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/crm/leads') ? 'active' : '' ?>">
                        <i class="bi bi-funnel-fill"></i> Leads Sales Pipeline
                    </a>
                    <a href="<?= Url::to('/admin/crm/batches') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/crm/batches') ? 'active' : '' ?>">
                        <i class="bi bi-calendar-event"></i> Academic Batches
                    </a>
                    <a href="<?= Url::to('/admin/crm/counselor') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/crm/counselor') ? 'active' : '' ?>">
                        <i class="bi bi-headset"></i> Counselor Desk & Demos
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('LMS.ViewCourses')): ?>
            <div class="nav-group" id="group-lms">
                <div class="nav-group-header">
                    <span><i class="bi bi-journal-bookmark-fill me-2"></i>Academic LMS Core</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/admin/lms/courses') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/lms/courses') ? 'active' : '' ?>">
                        <i class="bi bi-journal-bookmark-fill"></i> Courses & Hierarchy
                    </a>
                    <a href="<?= Url::to('/admin/lms/enrollments') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/lms/enrollments') ? 'active' : '' ?>">
                        <i class="bi bi-mortarboard"></i> Student Enrollments
                    </a>
                    <a href="<?= Url::to('/admin/lms/schedules') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/lms/schedules') ? 'active' : '' ?>">
                        <i class="bi bi-calendar3"></i> Class Timetables & Rooms
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('FINANCE.ViewPayments') && \App\Services\PlanFeatureService::hasModuleAccess('finance')): ?>
            <div class="nav-group" id="group-finance">
                <div class="nav-group-header">
                    <span><i class="bi bi-currency-rupee me-2"></i>Payments & Finance</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/admin/finance/dashboard') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/finance/dashboard') ? 'active' : '' ?>">
                        <i class="bi bi-pie-chart-fill text-gold"></i> Financial BI Dashboard
                    </a>
                    <a href="<?= Url::to('/admin/finance/payments') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/finance/payments') ? 'active' : '' ?>">
                        <i class="bi bi-currency-rupee"></i> Payment Transactions
                    </a>
                    <a href="<?= Url::to('/admin/finance/invoices') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/finance/invoices') ? 'active' : '' ?>">
                        <i class="bi bi-receipt-cutoff"></i> 18% GST Tax Invoices
                    </a>
                    <a href="<?= Url::to('/admin/finance/settings') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/finance/settings') ? 'active' : '' ?>">
                        <i class="bi bi-credit-card-2-front"></i> Payment Gateways & UPI
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('PLACEMENT.ManageJobs') && \App\Services\PlanFeatureService::hasModuleAccess('placement')): ?>
            <div class="nav-group" id="group-placement">
                <div class="nav-group-header">
                    <span><i class="bi bi-briefcase-fill me-2"></i>Placement & Career</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/admin/placement/jobs') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/placement/jobs') ? 'active' : '' ?>">
                        <i class="bi bi-briefcase-fill"></i> Job Openings Board
                    </a>
                    <a href="<?= Url::to('/admin/placement/applications') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/placement/applications') ? 'active' : '' ?>">
                        <i class="bi bi-person-lines-fill"></i> Student Applications
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('AUTOMATION.ManageCampaigns') && \App\Services\PlanFeatureService::hasModuleAccess('automation')): ?>
            <div class="nav-group" id="group-automation">
                <div class="nav-group-header">
                    <span><i class="bi bi-megaphone-fill me-2"></i>Marketing Automation</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/admin/automation/campaigns') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/automation/campaigns') ? 'active' : '' ?>">
                        <i class="bi bi-megaphone-fill"></i> Campaigns & Referrals
                    </a>
                    <a href="<?= Url::to('/admin/automation/coupons') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/automation/coupons') ? 'active' : '' ?>">
                        <i class="bi bi-ticket-perforated"></i> Discount Coupons
                    </a>
                    <a href="<?= Url::to('/admin/marketing/integrations') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/marketing/integrations') ? 'active' : '' ?>">
                        <i class="bi bi-plugin"></i> Meta & Google Ad Leads
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('SYSTEM.AdminConsole')): ?>
            <div class="nav-group" id="group-system">
                <div class="nav-group-header">
                    <span><i class="bi bi-cpu-fill me-2"></i>System Administration</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/admin/system/console') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/system/console') ? 'active' : '' ?>">
                        <i class="bi bi-sliders"></i> Admin Console & Cache
                    </a>
                    <a href="<?= Url::to('/admin/system/backups') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/system/backups') ? 'active' : '' ?>">
                        <i class="bi bi-database-fill-down"></i> Database Backups
                    </a>
                    <a href="<?= Url::to('/admin/system/health') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/system/health') ? 'active' : '' ?>">
                        <i class="bi bi-cpu-fill"></i> System Health Logs
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('COMMUNICATION.SendBroadcast')): ?>
            <div class="nav-group" id="group-communication">
                <div class="nav-group-header">
                    <span><i class="bi bi-broadcast-pin me-2"></i>Communication Hub</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/admin/communication/hub') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/communication/hub') ? 'active' : '' ?>">
                        <i class="bi bi-broadcast-pin"></i> Broadcast & Templates
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('CMS.ViewPages')): ?>
            <div class="nav-group" id="group-cms">
                <div class="nav-group-header">
                    <span><i class="bi bi-window-sidebar me-2"></i>Website CMS</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
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
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasRole('Admin')): ?>
            <div class="nav-group" id="group-users">
                <div class="nav-group-header">
                    <span><i class="bi bi-shield-lock me-2"></i>User Administration</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/admin/users') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/users') ? 'active' : '' ?>">
                        <i class="bi bi-people"></i> User Management
                    </a>
                    <a href="<?= Url::to('/admin/roles') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/admin/roles') ? 'active' : '' ?>">
                        <i class="bi bi-shield-lock"></i> Roles & Permissions
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('STUDENT.Portal')): ?>
            <div class="nav-group" id="group-student">
                <div class="nav-group-header">
                    <span><i class="bi bi-mortarboard me-2"></i>Student Classroom</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/student/dashboard') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/student/dashboard') ? 'active' : '' ?>">
                        <i class="bi bi-laptop"></i> Digital Classroom
                    </a>
                    <a href="<?= Url::to('/student/schedules') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/student/schedules') ? 'active' : '' ?>">
                        <i class="bi bi-calendar2-week"></i> Live Class Timetable
                    </a>
                    <a href="<?= Url::to('/student/assignments') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/student/assignments') ? 'active' : '' ?>">
                        <i class="bi bi-file-earmark-check"></i> Assignments Hub
                    </a>
                    <a href="<?= Url::to('/student/certificates') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/student/certificates') ? 'active' : '' ?>">
                        <i class="bi bi-award-fill"></i> My Certificates
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if (\App\Services\RbacService::hasPermission('FACULTY.Workspace')): ?>
            <div class="nav-group" id="group-faculty">
                <div class="nav-group-header">
                    <span><i class="bi bi-person-workspace me-2"></i>Faculty Workspace</span>
                    <i class="bi bi-chevron-down toggle-icon"></i>
                </div>
                <div class="nav-group-items">
                    <a href="<?= Url::to('/faculty/dashboard') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/faculty/dashboard') ? 'active' : '' ?>">
                        <i class="bi bi-person-workspace"></i> Instructor Desk
                    </a>
                    <a href="<?= Url::to('/faculty/schedules') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/faculty/schedules') ? 'active' : '' ?>">
                        <i class="bi bi-calendar-event"></i> My Timetables & Live Rooms
                    </a>
                    <a href="<?= Url::to('/faculty/assignments') ?>" class="nav-item-link <?= str_contains($_SERVER['REQUEST_URI'], '/faculty/assignments') ? 'active' : '' ?>">
                        <i class="bi bi-check-all"></i> Grade Submissions
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <div class="nav-group" id="group-account">
            <div class="nav-group-header">
                <span><i class="bi bi-person-circle me-2"></i>User Account</span>
                <i class="bi bi-chevron-down toggle-icon"></i>
            </div>
            <div class="nav-group-items">
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
        </div>
    </div>

    <div class="main-wrapper">
        <div class="top-navbar">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="globalSearchInput" placeholder="Search courses, blogs, users, leads, invoices..." autocomplete="off">
                <div class="search-results-dropdown" id="searchResultsDropdown"></div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- ⚡ Non-Tech Friendly Quick Action Speed Dial -->
                <div class="dropdown">
                    <button class="quick-action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>+ Quick Action</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end quick-action-menu">
                        <li><h6 class="dropdown-header text-uppercase text-muted font-monospace" style="font-size: 10px;">Common Operations</h6></li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/admin/crm/leads') ?>">
                                <i class="bi bi-person-plus-fill text-info"></i> Add / View CRM Leads
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/admin/crm/leads') ?>">
                                <i class="bi bi-cash-stack text-success"></i> Record Cash / Offline Payment
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/faculty/schedules') ?>">
                                <i class="bi bi-calendar-plus-fill text-warning"></i> Schedule Live Class
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/admin/communication/hub') ?>">
                                <i class="bi bi-megaphone-fill text-danger"></i> Send Broadcast Announcement
                            </a>
                        </li>
                    </ul>
                </div>
                <?php if (($_SESSION['user']['tenant_id'] ?? 1) === 1): ?>
                    <?php
                        $tenantModel = new \App\Models\Tenant();
                        $allTenants = $tenantModel->all();
                        $activeTenantId = \App\Core\TenantContext::getTenantId();
                        $activeTenantData = \App\Core\TenantContext::getTenantData();
                        $activeTenantName = $activeTenantData['name'] ?? ($activeTenantId === 1 ? 'Primary Academy (Global)' : "Tenant #{$activeTenantId}");
                    ?>
                    <div class="dropdown">
                        <button class="btn btn-sm rounded-pill px-3 font-weight-bold d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" style="background: rgba(217,174,104,0.15); color: #D9AE68; border: 1px solid #D9AE68;">
                            <i class="bi bi-building"></i>
                            <span>Workspace: <strong><?= Security::e($activeTenantName) ?></strong></span>
                            <i class="bi bi-chevron-down ms-1" style="font-size: 11px;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg py-2" style="background: #161F2B; border: 1px solid rgba(243,238,226,0.2); min-width: 250px;">
                            <li><h6 class="dropdown-header font-weight-bold text-uppercase" style="color: #D9AE68; font-size: 11px; letter-spacing: 0.05em;">Super Admin Workspace Switcher</h6></li>
                            <?php foreach ($allTenants as $t): ?>
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center py-2 px-3 <?= $activeTenantId == $t['id'] ? 'active bg-warning text-dark font-weight-bold' : 'text-white' ?>" href="<?= Url::to('/dashboard?t=' . $t['subdomain']) ?>">
                                        <span>#<?= $t['id'] ?> — <?= Security::e($t['name']) ?></span>
                                        <span class="badge ms-2 font-monospace" style="font-size: 10px; background: rgba(255,255,255,0.15);"><?= Security::e($t['subdomain']) ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <?php
                        $activeTenantData = \App\Core\TenantContext::getTenantData();
                        $academyName = $activeTenantData['name'] ?? 'My Academy';
                    ?>
                    <span class="badge px-3 py-2 font-weight-bold" style="background: rgba(59,130,246,0.15); color: #60A5FA; border: 1px solid rgba(59,130,246,0.3); font-size: 12px;">
                        <i class="bi bi-building mr-1"></i><?= Security::e($academyName) ?>
                    </span>
                <?php endif; ?>

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

        <div class="content-body" id="app-content">
            <?= \App\Helpers\Flash::render() ?>
            <?= $content ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Url::to('/assets/js/spa-engine.js') ?>"></script>
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
