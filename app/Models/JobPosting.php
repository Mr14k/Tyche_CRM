<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use App\Core\TenantContext;

class JobPosting extends Model
{
    protected string $table = 'job_postings';

    public function getJobsWithEmployers(): array
    {
        $tid = TenantContext::getTenantId();
        $sql = "SELECT j.*, e.company_name, e.logo_url, e.industry 
                FROM job_postings j
                LEFT JOIN employers e ON j.employer_id = e.id
                WHERE j.is_active = 1 AND j.tenant_id = :tid
                ORDER BY j.created_at DESC";
        return Database::fetchAll($sql, ['tid' => $tid]);
    }
}
