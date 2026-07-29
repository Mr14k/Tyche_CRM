<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Cms;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\MediaFile;
use App\Services\MediaLibraryService;
use App\Helpers\Flash;
use App\Helpers\Url;

class MediaController extends Controller
{
    private MediaFile $model;
    private MediaLibraryService $service;

    public function __construct()
    {
        parent::__construct();
        $this->model = new MediaFile();
        $this->service = new MediaLibraryService();
    }

    public function index(Request $request): void
    {
        $folder = $request->query('folder', 'all');
        $files = $this->model->getByFolder($folder);

        $this->view('admin.cms.media', [
            'pageTitle' => 'Centralized Media Library — Tyche Academy',
            'files' => $files,
            'currentFolder' => $folder
        ], 'admin');
    }

    public function upload(Request $request): void
    {
        $user = Session::get('user');
        $file = $request->file('media_file');
        $folder = $request->input('folder', 'uncategorized');
        $tags = $request->input('tags');

        if (!$file) {
            Flash::error('Please select a file to upload.');
            $this->redirect(Url::to('/admin/cms/media'));
        }

        $this->service->upload($file, (int)$user['id'], $folder, $tags);

        Flash::success("Media asset uploaded successfully.");
        $this->redirect(Url::to('/admin/cms/media'));
    }
}
