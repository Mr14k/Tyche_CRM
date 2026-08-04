<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Database;
use App\Core\TenantContext;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Services\LeadDedupeService;
use App\Services\LeadFollowupEngine;

class LeadCrmService extends Service
{
    private Lead $leadModel;
    private LeadActivity $activityModel;
    private LeadDedupeService $dedupeService;
    private LeadFollowupEngine $followupEngine;

    public function __construct()
    {
        $this->leadModel = new Lead();
        $this->activityModel = new LeadActivity();
        $this->dedupeService = new LeadDedupeService();
        $this->followupEngine = new LeadFollowupEngine();
    }

    public function createLead(array $data): array
    {
        // 1. Check for duplicates
        $dupeCheck = $this->dedupeService->checkOrProcessDuplicate($data);
        if ($dupeCheck) {
            return $dupeCheck;
        }

        // 2. Generate Lead Code & SLA Deadline
        $leadCode = 'LEAD-' . date('Y') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));
        $slaDueAt = date('Y-m-d H:i:s', strtotime('+2 hours'));

        $leadId = $this->leadModel->create([
            'lead_code' => $leadCode,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? '',
            'email' => $data['email'],
            'phone' => $data['phone'],
            'course_id' => !empty($data['course_id']) ? (int)$data['course_id'] : 1,
            'batch_id' => !empty($data['batch_id']) ? (int)$data['batch_id'] : null,
            'source' => $data['source'] ?? 'website_form',
            'counselor_id' => !empty($data['counselor_id']) ? (int)$data['counselor_id'] : 1,
            'priority' => $data['priority'] ?? 'medium',
            'status' => 'new',
            'lead_score' => 15,
            'sla_due_at' => $slaDueAt,
            'is_sla_breached' => 0,
            'last_interaction_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 3. Log Initial Activity
        $this->activityModel->create([
            'lead_id' => (int)$leadId,
            'user_id' => null,
            'type' => 'note',
            'outcome' => 'sent',
            'notes' => "Lead captured via [{$data['source']}]. SLA Deadline set to " . date('H:i', strtotime($slaDueAt)),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 4. Create Day 0 Task
        $this->followupEngine->createDayZeroTask((int)$leadId, !empty($data['counselor_id']) ? (int)$data['counselor_id'] : 1);

        return ['is_duplicate' => false, 'lead_id' => (int)$leadId, 'lead_code' => $leadCode];
    }

    public function updateStatus(int $leadId, string $status, ?string $lostReason = null, ?string $lostNotes = null, ?int $userId = null): void
    {
        $oldLead = $this->leadModel->find($leadId);
        if (!$oldLead) return;

        $scoreAddition = match ($status) {
            'contacted' => 25,
            'qualified' => 45,
            'nurturing' => 60,
            'application_sent' => 75,
            'payment_link_generated' => 85,
            'payment_received', 'enrolled' => 100,
            'lost' => 0,
            default => 15
        };

        $updateData = [
            'status' => $status,
            'lead_score' => $scoreAddition,
            'last_interaction_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($status === 'lost') {
            $updateData['lost_reason'] = $lostReason ?? 'other';
            $updateData['lost_notes'] = $lostNotes;
        }

        $this->leadModel->update($leadId, $updateData);

        // Log timeline activity
        $outcome = ($status === 'lost') ? 'lost' : (($status === 'enrolled') ? 'converted' : 'sent');
        $notes = "Stage updated from '{$oldLead['status']}' to '{$status}'.";
        if ($status === 'lost') {
            $notes .= " Reason: " . strtoupper(str_replace('_', ' ', $lostReason ?? 'other')) . ". Notes: {$lostNotes}";
        }

        $this->activityModel->create([
            'lead_id' => $leadId,
            'user_id' => $userId ?? 1,
            'type' => 'stage_change',
            'outcome' => $outcome,
            'notes' => $notes,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function assignCounselor(int $leadId, int $counselorId, ?int $userId = null): void
    {
        $oldLead = $this->leadModel->find($leadId);
        if (!$oldLead) return;

        $counselor = Database::fetchOne("SELECT first_name, last_name FROM users WHERE id = :id", ['id' => $counselorId]);
        $counselorName = $counselor ? trim(($counselor['first_name'] ?? '') . ' ' . ($counselor['last_name'] ?? '')) : "Counselor #{$counselorId}";

        $this->leadModel->update($leadId, [
            'counselor_id' => $counselorId,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->activityModel->create([
            'lead_id' => $leadId,
            'user_id' => $userId ?? 1,
            'type' => 'note',
            'outcome' => 'assigned',
            'notes' => "Lead assigned to counselor: {$counselorName}.",
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function logActivity(int $leadId, string $type, string $outcome, ?string $notes = null, ?int $durationSeconds = null, ?int $userId = null): void
    {
        $tid = TenantContext::getTenantId();

        $this->activityModel->create([
            'tenant_id' => $tid,
            'lead_id' => $leadId,
            'user_id' => $userId ?? 1,
            'type' => $type,
            'outcome' => $outcome,
            'notes' => $notes,
            'duration_seconds' => $durationSeconds ?: null,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->leadModel->update($leadId, [
            'last_interaction_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function reactivateLead(int $leadId, ?int $userId = null): void
    {
        $this->leadModel->update($leadId, [
            'status' => 'contacted',
            'lost_reason' => null,
            'lost_notes' => null,
            'reactivated_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->activityModel->create([
            'lead_id' => $leadId,
            'user_id' => $userId ?? 1,
            'type' => 'stage_change',
            'outcome' => 'reactivated',
            'notes' => "Lead reactivated from Lost status. Moved to 'Contacted' stage for fresh follow-up.",
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
