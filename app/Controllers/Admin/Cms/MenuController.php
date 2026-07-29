<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Cms;

use App\Core\Controller;
use App\Core\Request;
use App\Models\NavigationMenu;
use App\Helpers\Flash;
use App\Helpers\Url;

class MenuController extends Controller
{
    private NavigationMenu $menuModel;

    public function __construct()
    {
        parent::__construct();
        $this->menuModel = new NavigationMenu();
    }

    public function index(Request $request): void
    {
        $headerMenus = $this->menuModel->getByLocation('header');
        $footerMenus = $this->menuModel->getByLocation('footer');

        $this->view('admin.cms.menus', [
            'pageTitle' => 'Navigation Menu Manager — Tyche Academy',
            'headerMenus' => $headerMenus,
            'footerMenus' => $footerMenus
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'location' => 'required',
            'title' => 'required',
            'url' => 'required'
        ]);

        $this->menuModel->create([
            'location' => $data['location'],
            'title' => $data['title'],
            'url' => $data['url'],
            'sort_order' => (int)$request->input('sort_order', 0),
            'is_active' => 1
        ]);

        Flash::success("Navigation link '{$data['title']}' added successfully.");
        $this->redirect(Url::to('/admin/cms/menus'));
    }

    public function delete(Request $request, string $id): void
    {
        $this->menuModel->delete((int)$id);
        Flash::success("Navigation link removed.");
        $this->redirect(Url::to('/admin/cms/menus'));
    }
}
