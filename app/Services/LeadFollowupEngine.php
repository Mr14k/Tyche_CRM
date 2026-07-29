<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Database;
use App\Models\LeadFollowup;
use App\Models\LeadActivity;

class LeadFollowupEngine extends Service
{
    private LeadFollowup $followupModel;
    private LeadActivity $activityModel;

    public function __construct()
    {
        $this->followupModel = new LeadFollowup();
        $this->activityModel = new LeadActivity();
    }

    public function createDayZeroTask(int $leadId, ?int $counselorId = null): void
    {
        $taskDate = date('Y-m-d H:i:s', strtotime('+2 hours'));

        $this->followupModel->create([
            'lead_id' => $leadId,
            'counselor_id' => $counselorId ?? 1,
            'type' => 'call',
            'notes' => 'Day 0 Mandatory Initial Outreach: Conduct introduction call & assess course fit.',
            'next_followup_date' => $taskDate,
            'is_completed' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function logInteraction(int $leadId, int $userId, string $type, string $outcome, ?string $notes = null, ?int $durationSeconds = null): void
    {
        $this->activityModel->create([
            'lead_id' => $leadId,
            'user_id' => $userId,
            'type' => $type,
            'outcome' => $outcome,
            'notes' => $notes,
            'duration_seconds' => $durationSeconds,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Database::execute("UPDATE leads SET last_interaction_at = NOW(), updated_at = NOW() WHERE id = :id", ['id' => $leadId]);
    }

    public function checkAndFlagSlaBreaches(): int
    {
        $sql = "UPDATE leads 
                SET is_sla_breached = 1 
                WHERE status = 'new' 
                  AND is_sla_breached = 0 
                  AND sla_due_at IS NOT NULL 
                  AND sla_due_at < NOW()";
        return Database::execute($sql);
    }
}
