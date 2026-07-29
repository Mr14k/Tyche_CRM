<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Controller;
use App\Core\Request;
use App\Models\JobPosting;

class JobWebController extends Controller
{
    private JobPosting $jobModel;

    public function __construct()
    {
        parent::__construct();
        $this->jobModel = new JobPosting();
    }

    public function index(Request $request): void
    {
        $jobs = $this->jobModel->getJobsWithEmployers();
        $this->view('web.jobs.index', [
            'pageTitle' => 'Placement Cell & Hiring Partner Openings — Tyche Academy',
            'jobs' => $jobs
        ], 'public');
    }

    public function show(Request $request, string $slug): void
    {
        $job = \App\Core\Database::fetchOne("SELECT j.*, e.company_name, e.industry, e.contact_person, e.contact_email FROM job_postings j LEFT JOIN employers e ON j.employer_id = e.id WHERE j.slug = :slug LIMIT 1", ['slug' => $slug]);
        if (!$job) {
            $this->notFound();
        }

        $this->view('web.jobs.show', [
            'pageTitle' => $job['title'] . ' — Tyche Placement Cell',
            'job' => $job
        ], 'public');
    }
}
