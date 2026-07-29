<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Cms;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Page;
use App\Models\PageRevision;
use App\Models\SeoMetadata;
use App\Helpers\Format;
use App\Helpers\Flash;
use App\Helpers\Url;
use App\Models\ActivityLog;

class PageController extends Controller
{
    private Page $pageModel;
    private SeoMetadata $seoModel;
    private PageRevision $revisionModel;

    public function __construct()
    {
        parent::__construct();
        $this->pageModel = new Page();
        $this->seoModel = new SeoMetadata();
        $this->revisionModel = new PageRevision();
    }

    public function index(Request $request): void
    {
        $pages = $this->pageModel->all();
        $this->view('admin.cms.pages.index', [
            'pageTitle' => 'CMS Pages Management — Tyche Academy',
            'pages' => $pages
        ], 'admin');
    }

    public function create(Request $request): void
    {
        $this->view('admin.cms.pages.create', [
            'pageTitle' => 'Create New CMS Page — Tyche Academy'
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $user = Session::get('user');
        $data = $this->validate($request, [
            'title' => 'required|min:3',
            'slug' => 'required|unique:pages,slug',
            'content' => 'required',
            'status' => 'required'
        ]);

        $pageId = $this->pageModel->createWithRevision([
            'title' => $data['title'],
            'slug' => Format::slug($data['slug']),
            'content' => $data['content'],
            'template' => $request->input('template', 'default'),
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published' ? date('Y-m-d H:i:s') : null
        ], (int)$user['id']);

        if ($pageId) {
            // Save SEO metadata
            $this->seoModel->saveForEntity('page', (int)$pageId, [
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'keywords' => $request->input('keywords')
            ]);

            (new ActivityLog())->record((int)$user['id'], 'CMS', 'CREATE_PAGE', "Created page {$data['title']}", $request->ip());
            Flash::success("CMS Page '{$data['title']}' created successfully.");
        }

        $this->redirect(Url::to('/admin/cms/pages'));
    }

    public function edit(Request $request, string $id): void
    {
        $page = $this->pageModel->find((int)$id);
        if (!$page) {
            Flash::error('Page not found.');
            $this->redirect(Url::to('/admin/cms/pages'));
        }

        $seo = $this->seoModel->findForEntity('page', (int)$id);
        $revisions = $this->revisionModel->getForPage((int)$id);

        $this->view('admin.cms.pages.edit', [
            'pageTitle' => "Edit Page: {$page['title']} — Tyche Academy",
            'page' => $page,
            'seo' => $seo,
            'revisions' => $revisions
        ], 'admin');
    }

    public function update(Request $request, string $id): void
    {
        $user = Session::get('user');
        $data = $this->validate($request, [
            'title' => 'required|min:3',
            'slug' => 'required|unique:pages,slug,' . $id,
            'content' => 'required',
            'status' => 'required'
        ]);

        $this->pageModel->updateWithRevision((int)$id, [
            'title' => $data['title'],
            'slug' => Format::slug($data['slug']),
            'content' => $data['content'],
            'template' => $request->input('template', 'default'),
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published' ? date('Y-m-d H:i:s') : null
        ], (int)$user['id']);

        $this->seoModel->saveForEntity('page', (int)$id, [
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'keywords' => $request->input('keywords')
        ]);

        (new ActivityLog())->record((int)$user['id'], 'CMS', 'UPDATE_PAGE', "Updated page {$data['title']}", $request->ip());
        Flash::success("CMS Page updated successfully.");
        $this->redirect(Url::to('/admin/cms/pages/' . $id . '/edit'));
    }

    public function delete(Request $request, string $id): void
    {
        $user = Session::get('user');
        $this->pageModel->delete((int)$id);
        (new ActivityLog())->record((int)$user['id'], 'CMS', 'DELETE_PAGE', "Deleted page ID {$id}", $request->ip());
        Flash::success("Page deleted successfully.");
        $this->redirect(Url::to('/admin/cms/pages'));
    }
}
