<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Cms;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Faq;
use App\Helpers\Flash;
use App\Helpers\Url;

class FaqController extends Controller
{
    private Faq $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Faq();
    }

    public function index(Request $request): void
    {
        $faqs = $this->model->all();
        $this->view('admin.cms.faqs', [
            'pageTitle' => 'FAQ Manager — Tyche Academy',
            'faqs' => $faqs
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'category' => 'required',
            'question' => 'required',
            'answer' => 'required'
        ]);

        $this->model->create([
            'category' => $data['category'],
            'question' => $data['question'],
            'answer' => $data['answer'],
            'is_active' => 1
        ]);

        Flash::success("FAQ item added successfully.");
        $this->redirect(Url::to('/admin/cms/faqs'));
    }
}
