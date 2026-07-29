<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Models\FormSubmission;
use App\Models\NewsletterSubscriber;
use App\Exceptions\ValidationException;

class FormSubmissionService extends Service
{
    private FormSubmission $submissionModel;
    private NewsletterSubscriber $newsletterModel;

    public function __construct()
    {
        $this->submissionModel = new FormSubmission();
        $this->newsletterModel = new NewsletterSubscriber();
    }

    public function submitForm(string $formType, array $data, string $ip, ?string $userAgent): string|false
    {
        $metadata = json_encode([
            'ip' => $ip,
            'user_agent' => $userAgent,
            'submitted_at' => date('Y-m-d H:i:s'),
            'learning_tier' => $data['learning_tier'] ?? 'live_cohort'
        ]);

        $id = $this->submissionModel->create([
            'form_type' => $formType,
            'name' => $data['name'] ?? 'Anonymous',
            'email' => strtolower($data['email'] ?? ''),
            'phone' => $data['phone'] ?? null,
            'message' => $data['message'] ?? null,
            'metadata' => $metadata,
            'status' => 'new'
        ]);

        // Capture lead into Phase 9 CRM Pipeline
        try {
            $nameParts = explode(' ', trim($data['name'] ?? 'Inquiry'), 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            (new LeadCrmService())->createLead([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => strtolower($data['email'] ?? ''),
                'phone' => $data['phone'] ?? '+919999999999',
                'course_id' => !empty($data['course_id']) ? (int)$data['course_id'] : null,
                'source' => 'landing_page',
                'priority' => 'high'
            ]);
        } catch (\Exception $e) {
            // Log fallback if lead already exists or exception occurs
        }

        // Dispatch Admin System Notification
        (new NotificationService())->dispatch(
            null,
            'lead',
            'New Public Inquiry (' . strtoupper($formType) . ')',
            "Inquiry received from " . ($data['name'] ?? 'User') . " ({$data['email']})",
            '/admin/crm/leads'
        );

        return $id;
    }

    public function subscribeNewsletter(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException(['email' => ['Please provide a valid email address.']]);
        }

        $existing = $this->newsletterModel->findOneWhere('email', strtolower($email));
        if (!$existing) {
            $this->newsletterModel->create([
                'email' => strtolower($email),
                'status' => 'subscribed'
            ]);
        }
    }
}
