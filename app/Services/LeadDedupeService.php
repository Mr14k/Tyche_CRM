<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Database;
use App\Models\Lead;
use App\Models\LeadActivity;

class LeadDedupeService extends Service
{
    private Lead $leadModel;
    private LeadActivity $activityModel;

    public function __construct()
    {
        $this->leadModel = new Lead();
        $this->activityModel = new LeadActivity();
    }

    public function checkOrProcessDuplicate(array $data): ?array
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $data['phone'] ?? '');
        if (strlen($cleanPhone) >= 10) {
            $cleanPhone = substr($cleanPhone, -10);
        }

        $email = strtolower(trim($data['email'] ?? ''));

        // Use distinct parameter names for PDO compliance
        $sql = "SELECT * FROM leads 
                WHERE (RIGHT(REGEXP_REPLACE(phone, '[^0-9]', ''), 10) = :phone1 AND :phone2 != '') 
                   OR (LOWER(email) = :email1 AND :email2 != '')
                ORDER BY created_at DESC LIMIT 1";
        
        $existing = Database::fetchOne($sql, [
            'phone1' => $cleanPhone,
            'phone2' => $cleanPhone,
            'email1' => $email,
            'email2' => $email
        ]);

        if ($existing) {
            // Log interaction on existing lead instead of creating duplicate
            $source = $data['source'] ?? 'website_form';
            $this->activityModel->create([
                'lead_id' => (int)$existing['id'],
                'user_id' => null,
                'type' => 'duplicate_hit',
                'outcome' => 'duplicate_recorded',
                'notes' => "Duplicate inquiry captured via [{$source}]. Lead Score bumped (+5).",
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Update lead score and last interaction date
            $newScore = min(100, (int)$existing['lead_score'] + 5);
            $this->leadModel->update((int)$existing['id'], [
                'lead_score' => $newScore,
                'last_interaction_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return [
                'is_duplicate' => true,
                'lead_id' => (int)$existing['id'],
                'lead_code' => $existing['lead_code'],
                'status' => $existing['status']
            ];
        }

        return null; // Not a duplicate
    }
}
