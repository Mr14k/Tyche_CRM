<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Cms;

use App\Core\Controller;
use App\Core\Request;
use App\Models\FacultyProfile;
use App\Helpers\Flash;
use App\Helpers\Url;

class FacultyController extends Controller
{
    private FacultyProfile $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new FacultyProfile();
    }

    public function index(Request $request): void
    {
        $facultyList = $this->model->all();
        $this->view('admin.cms.faculty', [
            'pageTitle' => 'Faculty Showcase Manager — Tyche Academy',
            'facultyList' => $facultyList
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'designation' => 'required',
            'biography' => 'required'
        ]);

        $this->model->create([
            'name' => $data['name'],
            'designation' => $data['designation'],
            'biography' => $data['biography'],
            'skills' => $request->input('skills'),
            'is_featured' => $request->input('is_featured') ? 1 : 0
        ]);

        Flash::success("Faculty profile added successfully.");
        $this->redirect(Url::to('/admin/cms/faculty'));
    }
}
