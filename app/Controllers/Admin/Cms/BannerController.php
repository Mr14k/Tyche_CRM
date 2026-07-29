<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Cms;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Banner;
use App\Helpers\Flash;
use App\Helpers\Url;

class BannerController extends Controller
{
    private Banner $bannerModel;

    public function __construct()
    {
        parent::__construct();
        $this->bannerModel = new Banner();
    }

    public function index(Request $request): void
    {
        $banners = $this->bannerModel->all();
        $this->view('admin.cms.banners', [
            'pageTitle' => 'Banner & Popup Slider Manager — Tyche Academy',
            'banners' => $banners
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'type' => 'required',
            'image_url' => 'required'
        ]);

        $this->bannerModel->create([
            'title' => $data['title'],
            'type' => $data['type'],
            'image_url' => $data['image_url'],
            'button_text' => $request->input('button_text'),
            'button_url' => $request->input('button_url'),
            'is_active' => 1
        ]);

        Flash::success("Banner slider created successfully.");
        $this->redirect(Url::to('/admin/cms/banners'));
    }
}
