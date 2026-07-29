<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Content;

use App\Core\Controller;
use App\Core\Request;
use App\Models\CaseStudy;
use App\Models\SuccessStory;
use App\Helpers\Format;
use App\Helpers\Flash;
use App\Helpers\Url;

class CaseStudyController extends Controller
{
    private CaseStudy $caseModel;
    private SuccessStory $storyModel;

    public function __construct()
    {
        parent::__construct();
        $this->caseModel = new CaseStudy();
        $this->storyModel = new SuccessStory();
    }

    public function index(Request $request): void
    {
        $caseStudies = $this->caseModel->all();
        $stories = $this->storyModel->all();

        $this->view('admin.content.case_studies', [
            'pageTitle' => 'Case Studies & Student Stories — Tyche Academy',
            'caseStudies' => $caseStudies,
            'stories' => $stories
        ], 'admin');
    }

    public function storeCaseStudy(Request $request): void
    {
        $data = $this->validate($request, [
            'client_name' => 'required',
            'industry' => 'required',
            'title' => 'required',
            'problem_statement' => 'required',
            'solution' => 'required',
            'strategy' => 'required'
        ]);

        $resultsSummary = [
            'ROAS' => $request->input('roas', 'N/A'),
            'Leads' => $request->input('leads', 'N/A')
        ];

        $this->caseModel->create([
            'client_name' => $data['client_name'],
            'industry' => $data['industry'],
            'title' => $data['title'],
            'slug' => Format::slug($data['title']),
            'problem_statement' => $data['problem_statement'],
            'solution' => $data['solution'],
            'strategy' => $data['strategy'],
            'results_summary' => json_encode($resultsSummary),
            'is_featured' => $request->input('is_featured') ? 1 : 0
        ]);

        Flash::success("Case study added successfully.");
        $this->redirect(Url::to('/admin/content/case-studies'));
    }
}
