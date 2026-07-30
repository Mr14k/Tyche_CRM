<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Crm;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Database;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\Course;
use App\Models\Batch;
use App\Services\LeadCrmService;
use App\Services\CrmPaymentLinkService;
use App\Services\LeadBulkImportService;
use App\Services\CrmTelemetryService;
use App\Exceptions\NotFoundException;
use App\Helpers\Flash;
use App\Helpers\Url;

class LeadController extends Controller
{
    private Lead $leadModel;
    private LeadCrmService $crmService;
    private CrmTelemetryService $telemetryService;

    public function __construct()
    {
        parent::__construct();
        $this->leadModel = new Lead();
        $this->crmService = new LeadCrmService();
        $this->telemetryService = new CrmTelemetryService();
    }

    public function index(Request $request): void
    {
        $filters = [
            'status' => $request->input('status'),
            'source' => $request->input('source'),
            'counselor_id' => $request->input('counselor_id'),
            'course_id' => $request->input('course_id'),
            'is_sla_breached' => $request->input('is_sla_breached'),
            'search' => $request->input('search')
        ];

        $leads = $this->leadModel->getLeadsWithDetails($filters);
        $telemetry = $this->telemetryService->getExecutiveMetrics();

        $tid = \App\Core\TenantContext::getTenantId();
        $counselors = Database::fetchAll("SELECT id, first_name, last_name FROM users WHERE tenant_id = :tid ORDER BY first_name ASC", ['tid' => $tid]);
        $courses = Database::fetchAll("SELECT id, title FROM courses WHERE tenant_id = :tid ORDER BY title ASC", ['tid' => $tid]);

        $this->view('admin.crm.leads.index', [
            'pageTitle' => 'Leads Sales Pipeline & Lifecycle — Tyche CRM',
            'leads' => $leads,
            'filters' => $filters,
            'telemetry' => $telemetry,
            'counselors' => $counselors,
            'courses' => $courses
        ], 'admin');
    }

    public function show(Request $request, string $id): void
    {
        $lead = $this->leadModel->findLead360((int)$id);
        if (!$lead) {
            throw new NotFoundException("Lead record #{$id} not found.");
        }

        $activityModel = new LeadActivity();
        $activities = $activityModel->getActivitiesForLead((int)$id);

        $batchModel = new Batch();
        $batches = $batchModel->getActiveForCourse((int)$lead['course_id']);

        $counselors = Database::fetchAll("SELECT id, first_name, last_name FROM users ORDER BY first_name ASC");


        $this->view('admin.crm.leads.show', [
            'pageTitle' => "Lead 360°: {$lead['first_name']} {$lead['last_name']} ({$lead['lead_code']})",
            'lead' => $lead,
            'activities' => $activities,
            'batches' => $batches,
            'counselors' => $counselors
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $limit = \App\Services\PlanFeatureService::checkLimit('max_leads');
        if (!$limit['allowed']) {
            Flash::error($limit['message']);
            $this->redirect('/admin/crm/leads');
            return;
        }

        $data = $this->validate($request, [
            'first_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
        ]);

        $res = $this->crmService->createLead([
            'first_name' => $data['first_name'],
            'last_name' => $request->input('last_name', ''),
            'email' => $data['email'],
            'phone' => $data['phone'],
            'course_id' => $request->input('course_id', 1),
            'source' => $request->input('source', 'manual'),
            'counselor_id' => $request->input('counselor_id', 1),
            'priority' => $request->input('priority', 'medium')
        ]);

        if (!empty($res['is_duplicate'])) {
            Flash::warning("Lead with phone/email already exists. Appended new inquiry to Lead Code: {$res['lead_code']}");
            $this->redirect(Url::to('/admin/crm/leads/' . $res['lead_id']));
            return;
        }

        Flash::success("New lead created successfully! Code: {$res['lead_code']}");
        $this->redirect(Url::to('/admin/crm/leads/' . $res['lead_id']));
    }

    public function updateStage(Request $request, string $id): void
    {
        $status = $request->input('status');
        $lostReason = $request->input('lost_reason');
        $lostNotes = $request->input('lost_notes');

        $user = Session::get('user');
        $this->crmService->updateStatus((int)$id, (string)$status, $lostReason, $lostNotes, (int)($user['id'] ?? 1));

        Flash::success("Lead lifecycle stage updated to '" . strtoupper(str_replace('_', ' ', (string)$status)) . "'.");
        $this->redirect(Url::to('/admin/crm/leads/' . $id));
    }

    public function reactivate(Request $request, string $id): void
    {
        $user = Session::get('user');
        $this->crmService->reactivateLead((int)$id, (int)($user['id'] ?? 1));

        Flash::success("Lead reactivated successfully! Status updated to Contacted.");
        $this->redirect(Url::to('/admin/crm/leads/' . $id));
    }

    public function generatePaymentLink(Request $request, string $id): void
    {
        $courseId = (int)$request->input('course_id');
        $batchId = !empty($request->input('batch_id')) ? (int)$request->input('batch_id') : null;
        $amount = (float)$request->input('amount');

        $user = Session::get('user');
        $linkService = new CrmPaymentLinkService();
        $res = $linkService->generatePaymentLink((int)$id, $courseId, $batchId, $amount, (int)($user['id'] ?? 1));

        Flash::success("Statutory 18% GST Payment Link generated: " . $res['payment_url']);
        $this->redirect(Url::to('/admin/crm/leads/' . $id));
    }

    public function importCsv(Request $request): void
    {
        if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
            Flash::error("Please upload a valid CSV file.");
            $this->redirect(Url::to('/admin/crm/leads'));
            return;
        }

        $importer = new LeadBulkImportService();
        $res = $importer->processCsv($_FILES['csv_file']['tmp_name'], 1, 'bulk_import');

        Flash::success("Bulk Import Complete! Total Rows: {$res['total_rows']} | Imported New: {$res['imported']} | Duplicates Appended: {$res['duplicates_appended']}");
        $this->redirect(Url::to('/admin/crm/leads'));
    }
}
