<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Database;
use App\Models\Lead;
use App\Services\LeadDedupeService;

class LeadBulkImportService extends Service
{
    private LeadCrmService $crmService;
    private LeadDedupeService $dedupeService;

    public function __construct()
    {
        $this->crmService = new LeadCrmService();
        $this->dedupeService = new LeadDedupeService();
    }

    public function processCsv(string $filePath, int $counselorId = 1, string $defaultSource = 'bulk_import'): array
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new \Exception("CSV file could not be read.");
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \Exception("Failed to open CSV file.");
        }

        $header = fgetcsv($handle, 1000, ',');
        if (!$header) {
            fclose($handle);
            throw new \Exception("CSV file is empty.");
        }

        // Map column indices
        $headerLower = array_map(fn($h) => strtolower(trim((string)$h)), $header);
        $firstNameIdx = array_search('first_name', $headerLower) !== false ? array_search('first_name', $headerLower) : (array_search('name', $headerLower) !== false ? array_search('name', $headerLower) : 0);
        $lastNameIdx = array_search('last_name', $headerLower);
        $emailIdx = array_search('email', $headerLower);
        $phoneIdx = array_search('phone', $headerLower) !== false ? array_search('phone', $headerLower) : (array_search('mobile', $headerLower) !== false ? array_search('mobile', $headerLower) : 1);
        $courseIdx = array_search('course_id', $headerLower);

        $totalCount = 0;
        $importedCount = 0;
        $duplicateCount = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (empty($row) || count($row) < 2) continue;
            $totalCount++;

            $firstName = trim($row[$firstNameIdx] ?? 'Lead');
            $lastName = ($lastNameIdx !== false && isset($row[$lastNameIdx])) ? trim($row[$lastNameIdx]) : '';
            $email = ($emailIdx !== false && isset($row[$emailIdx])) ? trim($row[$emailIdx]) : 'lead_' . rand(1000, 9999) . '@tyche.academy';
            $phone = ($phoneIdx !== false && isset($row[$phoneIdx])) ? trim($row[$phoneIdx]) : '98765' . rand(10000, 99999);
            $courseId = ($courseIdx !== false && isset($row[$courseIdx])) ? (int)$row[$courseIdx] : 1;

            $leadData = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'course_id' => $courseId,
                'source' => $defaultSource,
                'counselor_id' => $counselorId
            ];

            $dedupe = $this->dedupeService->checkOrProcessDuplicate($leadData);
            if ($dedupe) {
                $duplicateCount++;
            } else {
                $this->crmService->createLead($leadData);
                $importedCount++;
            }
        }

        fclose($handle);

        return [
            'total_rows' => $totalCount,
            'imported' => $importedCount,
            'duplicates_appended' => $duplicateCount
        ];
    }
}
