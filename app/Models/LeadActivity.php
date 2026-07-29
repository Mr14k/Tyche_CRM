<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class LeadActivity extends Model
{
    protected string $table = 'lead_activities';

    public function getActivitiesForLead(int $leadId): array
    {
        $sql = "SELECT la.*, u.first_name as user_first, u.last_name as user_last, u.avatar 
                FROM lead_activities la
                LEFT JOIN users u ON la.user_id = u.id
                WHERE la.lead_id = :lead_id
                ORDER BY la.created_at DESC";
        return Database::fetchAll($sql, ['lead_id' => $leadId]);
    }
}
