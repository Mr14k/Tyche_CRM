<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Crm;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Database;
use App\Models\Lead;
use App\Models\LeadFollowup;
use App\Models\LeadActivity;
use App\Helpers\Flash;
use App\Helpers\Url;

class CounselorController extends Controller
{
    public function index(Request $request): void
    {
        $user = Session::get('user');
        
        $followups = Database::fetchAll("SELECT f.*, l.first_name, l.last_name, l.phone, l.lead_code 
            FROM lead_followups f
            JOIN leads l ON f.lead_id = l.id
            ORDER BY f.created_at DESC");

        $demos = Database::fetchAll("SELECT d.*, l.first_name, l.last_name, c.title as course_title 
            FROM demo_classes d
            JOIN leads l ON d.lead_id = l.id
            JOIN courses c ON d.course_id = c.id
            ORDER BY d.scheduled_at ASC");

        // Fetch all active leads for select dropdown
        $leads = Database::fetchAll("SELECT id, lead_code, first_name, last_name, phone, status 
            FROM leads 
            ORDER BY created_at DESC");

        $this->view('admin.crm.counselor', [
            'pageTitle' => 'Counselor Sales Desk & Demos — Tyche Academy',
            'followups' => $followups,
            'demos' => $demos,
            'leads' => $leads
        ], 'admin');
    }

    public function storeFollowup(Request $request): void
    {
        $user = Session::get('user');
        $data = $this->validate($request, [
            'lead_id' => 'required',
            'notes' => 'required'
        ]);

        $leadId = (int)$data['lead_id'];

        // Verify lead exists before insertion
        $leadModel = new Lead();
        $lead = $leadModel->find($leadId);

        if (!$lead) {
            Flash::error("Lead #{$leadId} does not exist in database. Please select a valid lead.");
            $this->redirect(Url::to('/admin/crm/counselor'));
            return;
        }

        $type = (string)$request->input('type', 'call');
        $counselorId = (int)($user['id'] ?? 1);

        // 1. Insert into lead_followups
        (new LeadFollowup())->create([
            'lead_id' => $leadId,
            'counselor_id' => $counselorId,
            'type' => $type,
            'notes' => $data['notes'],
            'is_completed' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 2. Also log to 360° lead_activities timeline
        (new LeadActivity())->create([
            'lead_id' => $leadId,
            'user_id' => $counselorId,
            'type' => $type,
            'outcome' => 'connected',
            'notes' => $data['notes'],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 3. Update lead status if new -> contacted
        if ($lead['status'] === 'new') {
            $leadModel->update($leadId, [
                'status' => 'contacted',
                'lead_score' => 25,
                'last_interaction_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            Database::execute("UPDATE leads SET last_interaction_at = NOW(), updated_at = NOW() WHERE id = :id", ['id' => $leadId]);
        }

        Flash::success("Follow-up call logged for {$lead['first_name']} {$lead['last_name']} ({$lead['lead_code']}).");
        $this->redirect(Url::to('/admin/crm/counselor'));
    }
}
