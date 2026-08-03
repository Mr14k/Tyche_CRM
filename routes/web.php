<?php

/** @var \App\Core\Router $router */

use App\Controllers\Web\HomeController;
use App\Controllers\Web\CmsPageController;
use App\Controllers\Web\SitemapController;
use App\Controllers\Web\BlogWebController;
use App\Controllers\Web\LmsWebController;
use App\Controllers\Web\CertificateVerificationController;
use App\Controllers\Web\JobWebController;

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\ForgotPasswordController;

use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\TenantController;
use App\Controllers\Admin\SubscriptionController;
use App\Controllers\Admin\SaasCommandCenterController;
use App\Controllers\Admin\UserManagementController;
use App\Controllers\Admin\RoleManagementController;
use App\Controllers\Admin\NotificationController;
use App\Controllers\Admin\GlobalSearchController;

use App\Controllers\Admin\Cms\PageController;
use App\Controllers\Admin\Cms\MenuController;
use App\Controllers\Admin\Cms\BannerController;
use App\Controllers\Admin\Cms\FacultyController;
use App\Controllers\Admin\Cms\FaqController;
use App\Controllers\Admin\Cms\MediaController;
use App\Controllers\Admin\Cms\FormController;
use App\Controllers\Admin\Cms\SettingsController;

use App\Controllers\Admin\Content\BlogController;
use App\Controllers\Admin\Blog\BlogAdminController;
use App\Controllers\Admin\Content\CaseStudyController;
use App\Controllers\Admin\Content\EventController;


use App\Controllers\Admin\Lms\CourseController;
use App\Controllers\Admin\Lms\EnrollmentController;

use App\Controllers\Admin\Crm\LeadController;
use App\Controllers\Admin\Crm\CounselorController;
use App\Controllers\Admin\Crm\BatchController;
use App\Controllers\Web\PaymentLinkWebController;


use App\Controllers\Admin\Finance\PaymentController;
use App\Controllers\Admin\Finance\InvoiceController;

use App\Controllers\Admin\Communication\NotificationHubController;

use App\Controllers\Admin\Bi\BiDashboardController;
use App\Controllers\Admin\Bi\ReportExportController;

use App\Controllers\Admin\Placement\JobController;
use App\Controllers\Admin\Placement\ApplicationController;

use App\Controllers\Admin\Automation\CampaignController;
use App\Controllers\Admin\Automation\CouponController;
use App\Controllers\Admin\Marketing\AdIntegrationController;
use App\Controllers\Webhooks\AdWebhookController;


use App\Controllers\Admin\System\AdminConsoleController;
use App\Controllers\Admin\System\BackupController;
use App\Controllers\Admin\System\HealthController;

use App\Controllers\Student\StudentDashboardController;
use App\Controllers\Student\StudentQuizController;
use App\Controllers\Student\StudentAssignmentController;
use App\Controllers\Student\StudentCertificateController;

use App\Controllers\Faculty\FacultyDashboardController;
use App\Controllers\Faculty\FacultyAssignmentController;

use App\Controllers\Account\ProfileController;

// ----------------------------------------------------
// Public Website & Placement Portal Routes
// ----------------------------------------------------
$router->get('/', [HomeController::class, 'index'])->name('home');
$router->get('/page/{slug}', [CmsPageController::class, 'show'])->name('cms.page');
$router->post('/submit-form', [CmsPageController::class, 'processForm'])->name('cms.form');
$router->post('/subscribe-newsletter', [CmsPageController::class, 'processNewsletter'])->name('cms.newsletter');
$router->get('/contact', [CmsPageController::class, 'contact'])->name('web.contact');
$router->get('/privacy-policy', [CmsPageController::class, 'privacy'])->name('web.privacy');
$router->get('/terms-of-service', [CmsPageController::class, 'terms'])->name('web.terms');
$router->get('/verify-invoice', [CmsPageController::class, 'verifyInvoice'])->name('web.verify_invoice');
$router->get('/pay/{code}', [PaymentLinkWebController::class, 'show'])->name('web.payment_link');
$router->post('/pay/{code}', [PaymentLinkWebController::class, 'process'])->middleware('csrf');
$router->get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap');



$router->get('/blog', [BlogWebController::class, 'index'])->name('web.blog');
$router->get('/blog/{slug}', [BlogWebController::class, 'show'])->name('web.blog.show');
$router->get('/case-studies', [BlogWebController::class, 'caseStudies'])->name('web.case_studies');
$router->get('/events', [BlogWebController::class, 'events'])->name('web.events');

$router->get('/jobs', [JobWebController::class, 'index'])->name('web.jobs');
$router->get('/jobs/{slug}', [JobWebController::class, 'show'])->name('web.jobs.show');

$router->get('/verify-certificate/{code}', [CertificateVerificationController::class, 'verify'])->name('web.cert.verify');

// ----------------------------------------------------
// Public Ad-Sourced Lead Webhook Receivers (Meta & Google Ads)
// ----------------------------------------------------
$router->get('/webhooks/meta/leadgen', [AdWebhookController::class, 'metaChallenge']);
$router->post('/webhooks/meta/leadgen', [AdWebhookController::class, 'metaLeadgen']);
$router->post('/webhooks/google/leadform', [AdWebhookController::class, 'googleLeadform']);

// ----------------------------------------------------
// Student LMS Catalog & Player Routes
// ----------------------------------------------------
$router->get('/courses', [LmsWebController::class, 'catalog'])->name('lms.catalog');
$router->get('/courses/{slug}', [LmsWebController::class, 'showCourse'])->name('lms.course');
$router->get('/courses/{slug}/checkout', [LmsWebController::class, 'checkoutPage'])->name('lms.checkout');
$router->post('/courses/{slug}/register-and-buy', [LmsWebController::class, 'registerAndBuy'])->middleware('csrf');
$router->post('/courses/{slug}/process-buy', [LmsWebController::class, 'processBuy'])->middleware('csrf');
$router->get('/courses/{slug}/learn/{lessonId}', [LmsWebController::class, 'player'])->name('lms.player');
$router->post('/courses/progress/update', [LmsWebController::class, 'updateProgress'])->middleware('csrf');
$router->post('/courses/notes/save', [LmsWebController::class, 'saveNote'])->middleware('csrf');


// ----------------------------------------------------
// Guest Authentication Routes
// ----------------------------------------------------
$router->group(['middleware' => ['guest']], function($router) {
    $router->get('/login', [LoginController::class, 'showLogin'])->name('login');
    $router->post('/login', [LoginController::class, 'processLogin'])->middleware('csrf');

    $router->get('/forgot-password', [ForgotPasswordController::class, 'showForgot'])->name('forgot');
    $router->post('/forgot-password', [ForgotPasswordController::class, 'processForgot'])->middleware('csrf');

    $router->get('/reset-password', [ForgotPasswordController::class, 'showReset'])->name('reset');
    $router->post('/reset-password', [ForgotPasswordController::class, 'processReset'])->middleware('csrf');
});

// ----------------------------------------------------
// Authenticated Shared Routes
// ----------------------------------------------------
$router->group(['middleware' => ['auth']], function($router) {
    $router->post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('csrf');

    $router->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    $router->get('/admin/search', [GlobalSearchController::class, 'search'])->name('admin.search');
    $router->get('/admin/notifications', [NotificationController::class, 'index'])->name('admin.notifications');
    $router->post('/admin/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->middleware('csrf');

    $router->get('/account/profile', [ProfileController::class, 'showProfile'])->name('profile');
    $router->post('/account/profile', [ProfileController::class, 'updateProfile'])->middleware('csrf');
    $router->post('/account/avatar', [ProfileController::class, 'updateAvatar'])->middleware('csrf');
    $router->post('/account/password', [ProfileController::class, 'changePassword'])->middleware('csrf');
});

// ----------------------------------------------------
// Student Portal Routes (Phase 6 & 8)
// ----------------------------------------------------
$router->group(['prefix' => '/student', 'middleware' => ['auth', 'perm:STUDENT.Portal']], function($router) {
    $router->get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    $router->get('/quizzes/{id}', [StudentQuizController::class, 'show'])->name('student.quiz');
    $router->post('/quizzes/{id}', [StudentQuizController::class, 'submit'])->middleware('csrf');

    $router->get('/assignments', [StudentAssignmentController::class, 'index'])->name('student.assignments');
    $router->post('/assignments', [StudentAssignmentController::class, 'store'])->middleware('csrf');

    $router->get('/certificates', [StudentCertificateController::class, 'index'])->name('student.certificates');
    $router->post('/certificates/{courseId}/generate', [StudentCertificateController::class, 'generate'])->middleware('csrf');
});

// ----------------------------------------------------
// Faculty Workspace Routes (Phase 7 & 8)
// ----------------------------------------------------
$router->group(['prefix' => '/faculty', 'middleware' => ['auth', 'perm:FACULTY.Workspace']], function($router) {
    $router->get('/dashboard', [FacultyDashboardController::class, 'index'])->name('faculty.dashboard');
    $router->get('/assignments', [FacultyAssignmentController::class, 'index'])->name('faculty.assignments');
    $router->post('/assignments/{id}/grade', [FacultyAssignmentController::class, 'grade'])->middleware('csrf');
});


// ----------------------------------------------------
// Admin Control Center Routes (Phases 2 - 14)
// ----------------------------------------------------
$router->group(['prefix' => '/admin', 'middleware' => ['auth', 'tenant']], function($router) {
    // Multi-Tenant Pilot Academy Management
    $router->get('/tenants', [TenantController::class, 'index'])->name('admin.tenants')->middleware('role:Admin');
    $router->post('/tenants', [TenantController::class, 'store'])->middleware('csrf')->middleware('role:Admin');
    $router->post('/tenants/{id}', [TenantController::class, 'update'])->middleware('csrf')->middleware('role:Admin');
    $router->post('/tenants/{id}/plan', [TenantController::class, 'updatePlan'])->middleware('csrf')->middleware('role:Admin');
    $router->post('/tenants/{id}/toggle-status', [TenantController::class, 'toggleStatus'])->middleware('csrf')->middleware('role:Admin');
    $router->post('/tenants/{id}/delete', [TenantController::class, 'delete'])->middleware('csrf')->middleware('role:Admin');

    // SaaS Subscription & Tier Manager
    $router->get('/subscriptions', [SubscriptionController::class, 'index'])->name('admin.subscriptions')->middleware('role:Admin');
    $router->post('/subscriptions/plans', [SubscriptionController::class, 'storePlan'])->middleware('csrf')->middleware('role:Admin');
    $router->post('/subscriptions/plans/{id}', [SubscriptionController::class, 'updatePlan'])->middleware('csrf')->middleware('role:Admin');
    $router->post('/subscriptions/reminder/{id}', [SubscriptionController::class, 'sendRenewalReminder'])->middleware('csrf')->middleware('role:Admin');

    // SaaS Command Center (Global Tower & AWS Console view)
    $router->get('/saas/command-center', [SaasCommandCenterController::class, 'index'])->name('admin.saas.command_center')->middleware('role:Admin');
    $router->post('/saas/command-center/action', [SaasCommandCenterController::class, 'executeAction'])->middleware('csrf')->middleware('role:Admin');

    // User & RBAC Management
    $router->get('/users', [UserManagementController::class, 'index'])->name('admin.users')->middleware('role:Admin');
    $router->post('/users', [UserManagementController::class, 'store'])->middleware('csrf')->middleware('role:Admin');
    $router->post('/users/{id}', [UserManagementController::class, 'update'])->middleware('csrf')->middleware('role:Admin');
    $router->post('/users/{id}/toggle-status', [UserManagementController::class, 'toggleStatus'])->middleware('csrf')->middleware('role:Admin');
    $router->post('/users/{id}/delete', [UserManagementController::class, 'delete'])->middleware('csrf')->middleware('role:Admin');

    $router->get('/roles', [RoleManagementController::class, 'index'])->name('admin.roles')->middleware('role:Admin');
    $router->post('/roles/matrix', [RoleManagementController::class, 'updateMatrix'])->middleware('csrf')->middleware('role:Admin');


    // Executive BI & Reporting (Phase 12)
    $router->get('/bi/dashboard', [BiDashboardController::class, 'index'])->name('admin.bi.dashboard')->middleware('perm:BI.ViewReports');
    $router->get('/bi/export', [ReportExportController::class, 'exportCsv'])->name('admin.bi.export')->middleware('perm:BI.ExportData');

    // Placement Cell (Phase 13)
    $router->get('/placement/jobs', [JobController::class, 'index'])->name('admin.placement.jobs')->middleware('perm:PLACEMENT.ManageJobs');
    $router->post('/placement/jobs', [JobController::class, 'store'])->middleware('csrf')->middleware('perm:PLACEMENT.ManageJobs');
    $router->get('/placement/applications', [ApplicationController::class, 'index'])->name('admin.placement.applications')->middleware('perm:PLACEMENT.ViewApplications');
    $router->post('/placement/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->middleware('csrf')->middleware('perm:PLACEMENT.ViewApplications');

    // Marketing Automation & Coupons (Phase 14)
    $router->get('/automation/campaigns', [CampaignController::class, 'index'])->name('admin.automation.campaigns')->middleware('perm:AUTOMATION.ManageCampaigns');
    $router->post('/automation/campaigns', [CampaignController::class, 'store'])->middleware('csrf')->middleware('perm:AUTOMATION.ManageCampaigns');
    $router->get('/automation/coupons', [CouponController::class, 'index'])->name('admin.automation.coupons')->middleware('perm:AUTOMATION.ManageCoupons');
    $router->post('/automation/coupons', [CouponController::class, 'store'])->middleware('csrf')->middleware('perm:AUTOMATION.ManageCoupons');

    // System Administration & Health (Phase 14)
    $router->get('/system/console', [AdminConsoleController::class, 'index'])->name('admin.system.console')->middleware('perm:SYSTEM.AdminConsole');
    $router->post('/system/cache/clear', [AdminConsoleController::class, 'clearCache'])->middleware('csrf')->middleware('perm:SYSTEM.AdminConsole');
    $router->get('/system/backups', [BackupController::class, 'index'])->name('admin.system.backups')->middleware('perm:SYSTEM.Backup');
    $router->post('/system/backups/generate', [BackupController::class, 'generate'])->middleware('csrf')->middleware('perm:SYSTEM.Backup');
    $router->get('/system/health', [HealthController::class, 'index'])->name('admin.system.health')->middleware('perm:SYSTEM.Health');

    // CRM Pipeline & Admissions (Phase 9)
    $router->get('/crm/leads', [LeadController::class, 'index'])->name('admin.crm.leads')->middleware('perm:CRM.ViewLeads');
    $router->get('/crm/leads/{id}', [LeadController::class, 'show'])->name('admin.crm.leads.show')->middleware('perm:CRM.ViewLeads');
    $router->post('/crm/leads', [LeadController::class, 'store'])->middleware('csrf')->middleware('perm:CRM.CreateLead');
    $router->post('/crm/leads/{id}/status', [LeadController::class, 'updateStage'])->middleware('csrf')->middleware('perm:CRM.EditLead');
    $router->post('/crm/leads/{id}/stage', [LeadController::class, 'updateStage'])->middleware('csrf')->middleware('perm:CRM.EditLead');
    $router->post('/crm/leads/{id}/reactivate', [LeadController::class, 'reactivate'])->middleware('csrf')->middleware('perm:CRM.EditLead');
    $router->post('/crm/leads/{id}/payment-link', [LeadController::class, 'generatePaymentLink'])->middleware('csrf')->middleware('perm:CRM.EditLead');
    $router->post('/crm/leads/import', [LeadController::class, 'importCsv'])->middleware('csrf')->middleware('perm:CRM.EditLead');

    $router->get('/crm/batches', [BatchController::class, 'index'])->name('admin.crm.batches')->middleware('perm:CRM.ViewLeads');
    $router->post('/crm/batches', [BatchController::class, 'store'])->middleware('csrf')->middleware('perm:CRM.EditLead');

    $router->get('/crm/counselor', [CounselorController::class, 'index'])->name('admin.crm.counselor')->middleware('perm:CRM.CounselorDashboard');
    $router->post('/crm/counselor/followup', [CounselorController::class, 'storeFollowup'])->middleware('csrf')->middleware('perm:CRM.CounselorDashboard');


    // Payments & GST Invoices (Phase 10)
    $router->get('/finance/payments', [PaymentController::class, 'index'])->name('admin.finance.payments')->middleware('perm:FINANCE.ViewPayments');
    $router->post('/finance/payments', [PaymentController::class, 'store'])->middleware('csrf')->middleware('perm:FINANCE.ViewPayments');
    $router->post('/finance/payments/{id}/generate-invoice', [PaymentController::class, 'generateInvoice'])->middleware('csrf')->middleware('perm:FINANCE.ViewPayments');
    $router->get('/finance/settings', [PaymentController::class, 'settings'])->name('admin.finance.settings')->middleware('perm:FINANCE.ViewPayments');
    $router->post('/finance/settings', [PaymentController::class, 'updateSettings'])->middleware('csrf')->middleware('perm:FINANCE.ViewPayments');
    $router->get('/finance/invoices', [InvoiceController::class, 'index'])->name('admin.finance.invoices')->middleware('perm:FINANCE.ManageInvoices');
    $router->get('/finance/invoices/{id}/view', [InvoiceController::class, 'showInvoice'])->name('admin.finance.invoices.view')->middleware('perm:FINANCE.ManageInvoices');



    // Communication & Notification Hub (Phase 11)
    $router->get('/communication/hub', [NotificationHubController::class, 'index'])->name('admin.communication.hub')->middleware('perm:COMMUNICATION.SendBroadcast');
    $router->post('/communication/broadcast', [NotificationHubController::class, 'broadcast'])->middleware('csrf')->middleware('perm:COMMUNICATION.SendBroadcast');

    // Meta & Google Ads Lead Ingestion (Phase 2 Module)
    $router->get('/marketing/integrations', [AdIntegrationController::class, 'index'])->name('admin.marketing.integrations')->middleware('perm:AUTOMATION.ManageCampaigns');
    $router->post('/marketing/integrations/meta', [AdIntegrationController::class, 'saveMeta'])->middleware('csrf')->middleware('perm:AUTOMATION.ManageCampaigns');
    $router->post('/marketing/integrations/google', [AdIntegrationController::class, 'saveGoogle'])->middleware('csrf')->middleware('perm:AUTOMATION.ManageCampaigns');


    // CMS Management
    $router->get('/cms/pages', [PageController::class, 'index'])->name('admin.cms.pages')->middleware('perm:CMS.ViewPages');
    $router->get('/cms/pages/create', [PageController::class, 'create'])->name('admin.cms.pages.create')->middleware('perm:CMS.CreatePage');
    $router->post('/cms/pages', [PageController::class, 'store'])->middleware('csrf')->middleware('perm:CMS.CreatePage');
    $router->get('/cms/pages/{id}/edit', [PageController::class, 'edit'])->name('admin.cms.pages.edit')->middleware('perm:CMS.EditPage');
    $router->post('/cms/pages/{id}', [PageController::class, 'update'])->middleware('csrf')->middleware('perm:CMS.EditPage');
    $router->post('/cms/pages/{id}/delete', [PageController::class, 'delete'])->middleware('csrf')->middleware('perm:CMS.DeletePage');

    $router->get('/cms/menus', [MenuController::class, 'index'])->name('admin.cms.menus')->middleware('perm:CMS.ManageMenus');
    $router->post('/cms/menus', [MenuController::class, 'store'])->middleware('csrf')->middleware('perm:CMS.ManageMenus');
    $router->post('/cms/menus/{id}/delete', [MenuController::class, 'delete'])->middleware('csrf')->middleware('perm:CMS.ManageMenus');

    $router->get('/cms/banners', [BannerController::class, 'index'])->name('admin.cms.banners')->middleware('perm:CMS.ManageBanners');
    $router->post('/cms/banners', [BannerController::class, 'store'])->middleware('csrf')->middleware('perm:CMS.ManageBanners');

    $router->get('/cms/faculty', [FacultyController::class, 'index'])->name('admin.cms.faculty')->middleware('perm:CMS.ManageFaculty');

    // Blog Article Publisher Module
    $router->get('/blog', [BlogAdminController::class, 'index'])->name('admin.blog')->middleware('perm:CMS.ViewPages');
    $router->get('/blog/create', [BlogAdminController::class, 'create'])->name('admin.blog.create')->middleware('perm:CMS.CreatePage');
    $router->post('/blog', [BlogAdminController::class, 'store'])->middleware('csrf')->middleware('perm:CMS.CreatePage');
    $router->get('/blog/{id}/edit', [BlogAdminController::class, 'edit'])->name('admin.blog.edit')->middleware('perm:CMS.EditPage');
    $router->post('/blog/{id}', [BlogAdminController::class, 'update'])->middleware('csrf')->middleware('perm:CMS.EditPage');
    $router->post('/blog/{id}/delete', [BlogAdminController::class, 'delete'])->middleware('csrf')->middleware('perm:CMS.DeletePage');

    $router->post('/cms/faculty', [FacultyController::class, 'store'])->middleware('csrf')->middleware('perm:CMS.ManageFaculty');

    $router->get('/cms/faqs', [FaqController::class, 'index'])->name('admin.cms.faqs')->middleware('perm:CMS.ManageFaqs');
    $router->post('/cms/faqs', [FaqController::class, 'store'])->middleware('csrf')->middleware('perm:CMS.ManageFaqs');

    $router->get('/cms/media', [MediaController::class, 'index'])->name('admin.cms.media')->middleware('perm:CMS.ManageMedia');
    $router->post('/cms/media/upload', [MediaController::class, 'upload'])->middleware('csrf')->middleware('perm:CMS.ManageMedia');

    $router->get('/cms/forms', [FormController::class, 'index'])->name('admin.cms.forms')->middleware('perm:CMS.ManageForms');
    $router->get('/cms/settings', [SettingsController::class, 'index'])->name('admin.cms.settings')->middleware('perm:CMS.ManageSettings');
    $router->post('/cms/settings', [SettingsController::class, 'update'])->middleware('csrf')->middleware('perm:CMS.ManageSettings');

    // Content Marketing Engine
    $router->get('/content/blogs', [BlogController::class, 'index'])->name('admin.content.blogs')->middleware('perm:BLOG.View');
    $router->get('/content/blogs/create', [BlogController::class, 'create'])->name('admin.content.blogs.create')->middleware('perm:BLOG.Create');
    $router->post('/content/blogs', [BlogController::class, 'store'])->middleware('csrf')->middleware('perm:BLOG.Create');
    $router->post('/content/blogs/autosave', [BlogController::class, 'autoSave'])->middleware('csrf')->middleware('perm:BLOG.Create');

    $router->get('/content/case-studies', [CaseStudyController::class, 'index'])->name('admin.content.case_studies')->middleware('perm:CASE_STUDIES.Manage');
    $router->post('/content/case-studies', [CaseStudyController::class, 'storeCaseStudy'])->middleware('csrf')->middleware('perm:CASE_STUDIES.Manage');

    $router->get('/content/events', [EventController::class, 'index'])->name('admin.content.events')->middleware('perm:EVENTS.Manage');
    $router->post('/content/events', [EventController::class, 'store'])->middleware('csrf')->middleware('perm:EVENTS.Manage');

    // LMS Core Architecture
    $router->get('/lms/courses', [CourseController::class, 'index'])->name('admin.lms.courses')->middleware('perm:LMS.ViewCourses');
    $router->get('/lms/courses/create', [CourseController::class, 'create'])->name('admin.lms.courses.create')->middleware('perm:LMS.CreateCourse');
    $router->post('/lms/courses', [CourseController::class, 'store'])->middleware('csrf')->middleware('perm:LMS.CreateCourse');
    $router->get('/lms/courses/{id}/edit', [CourseController::class, 'edit'])->name('admin.lms.courses.edit')->middleware('perm:LMS.EditCourse');
    $router->post('/lms/courses/{id}/update', [CourseController::class, 'update'])->middleware('csrf')->middleware('perm:LMS.EditCourse');

    $router->post('/lms/courses/{id}/modules', [CourseController::class, 'storeModule'])->middleware('csrf')->middleware('perm:LMS.EditCourse');
    $router->post('/lms/courses/{id}/chapters', [CourseController::class, 'storeChapter'])->middleware('csrf')->middleware('perm:LMS.EditCourse');
    $router->post('/lms/courses/{id}/lessons', [CourseController::class, 'storeLesson'])->middleware('csrf')->middleware('perm:LMS.ManageLessons');

    $router->get('/lms/enrollments', [EnrollmentController::class, 'index'])->name('admin.lms.enrollments')->middleware('perm:LMS.ManageEnrollments');
    $router->post('/lms/enrollments', [EnrollmentController::class, 'store'])->middleware('csrf')->middleware('perm:LMS.ManageEnrollments');
});
