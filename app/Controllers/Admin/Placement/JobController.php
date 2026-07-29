<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Placement;

use App\Core\Controller;
use App\Core\Request;
use App\Models\JobPosting;
use App\Models\Employer;
use App\Helpers\Flash;
use App\Helpers\Url;

class JobController extends Controller
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
        $employers = (new Employer())->all();

        $this->view('admin.placement.jobs.index', [
            'pageTitle' => 'Placement Cell Job Postings — Tyche Academy',
            'jobs' => $jobs,
            'employers' => $employers
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'location' => 'required',
            'salary_range' => 'required',
            'description' => 'required',
            'requirements' => 'required'
        ]);

        $slug = \App\Helpers\StringHelper::slug($data['title']) . '-' . rand(100, 999);

        $this->jobModel->create([
            'employer_id' => !empty($request->input('employer_id')) ? (int)$request->input('employer_id') : null,
            'title' => $data['title'],
            'slug' => $slug,
            'type' => $request->input('type', 'full_time'),
            'location' => $data['location'],
            'salary_range' => $data['salary_range'],
            'description' => $data['description'],
            'requirements' => $data['requirements'],
            'deadline' => date('Y-m-d', strtotime('+30 days')),
            'is_active' => 1
        ]);

        Flash::success("Job opening '{$data['title']}' published to placement portal.");
        $this->redirect(Url::to('/admin/placement/jobs'));
    }
}
