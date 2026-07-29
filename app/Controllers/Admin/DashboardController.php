<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\LoginHistory;
use App\Models\Payment;
use App\Services\BusinessIntelligenceService;
use App\Core\Session;
use App\Services\RbacService;
use App\Helpers\Url;

class DashboardController extends Controller
{
    public function index(Request $request): void
    {
        $user = Session::get('user');

        // If user is a Counselor (and not a Super Admin/Admin), redirect directly to Counselor Sales Desk
        if (!RbacService::hasRole('Admin') && RbacService::hasPermission('CRM.CounselorDashboard')) {
            $this->redirect(Url::to('/admin/crm/counselor'));
            return;
        }

        // If user has CRM Leads access (and not an Admin), redirect to Lead Pipeline
        if (!RbacService::hasRole('Admin') && RbacService::hasPermission('CRM.ViewLeads')) {
            $this->redirect(Url::to('/admin/crm/leads'));
            return;
        }

        // If user is a Student (and not an Admin), redirect to Student Digital Classroom
        if (!RbacService::hasRole('Admin') && RbacService::hasPermission('STUDENT.Portal')) {
            $this->redirect(Url::to('/student/dashboard'));
            return;
        }

        // If user is Faculty (and not an Admin), redirect to Faculty Workspace
        if (!RbacService::hasRole('Admin') && RbacService::hasPermission('FACULTY.Workspace')) {
            $this->redirect(Url::to('/faculty/dashboard'));
            return;
        }

        $userModel = new User();
        $activityModel = new ActivityLog();
        $loginModel = new LoginHistory();
        $paymentModel = new Payment();
        $biService = new BusinessIntelligenceService();

        $allUsers = $userModel->all();
        $recentActivities = $activityModel->all();
        $loginLogs = $loginModel->all();
        $recentPayments = $paymentModel->getPaymentsWithDetails();
        $executiveMetrics = $biService->getExecutiveMetrics();

        $this->view('admin.dashboard', [
            'pageTitle' => 'Platform Control Center — Tyche Academy',
            'user' => $user,
            'totalUsers' => count($allUsers),
            'recentActivities' => array_slice($recentActivities, 0, 10),
            'recentLogins' => array_slice($loginLogs, 0, 10),
            'recentPayments' => array_slice($recentPayments, 0, 8),
            'metrics' => $executiveMetrics
        ], 'admin');
    }
}
