<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Content;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Services\BlogService;
use App\Helpers\Format;
use App\Helpers\Flash;
use App\Helpers\Url;
use App\Models\ActivityLog;

class BlogController extends Controller
{
    private BlogPost $postModel;
    private BlogCategory $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->postModel = new BlogPost();
        $this->categoryModel = new BlogCategory();
    }

    public function index(Request $request): void
    {
        $posts = $this->postModel->all();
        $this->view('admin.content.blogs.index', [
            'pageTitle' => 'Blog Posts Management — Tyche Academy',
            'posts' => $posts
        ], 'admin');
    }

    public function create(Request $request): void
    {
        $categories = $this->categoryModel->all();
        $this->view('admin.content.blogs.create', [
            'pageTitle' => 'Create New Blog Post — Tyche Academy',
            'categories' => $categories
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $user = Session::get('user');
        $data = $this->validate($request, [
            'title' => 'required|min:3',
            'slug' => 'required|unique:blog_posts,slug',
            'content' => 'required',
            'status' => 'required'
        ]);

        $readingTime = (int)ceil(str_word_count(strip_tags($data['content'])) / 200);

        $postId = $this->postModel->create([
            'title' => $data['title'],
            'slug' => Format::slug($data['slug']),
            'summary' => $request->input('summary'),
            'content' => $data['content'],
            'category_id' => $request->input('category_id') ? (int)$request->input('category_id') : null,
            'author_id' => (int)$user['id'],
            'reading_time_minutes' => max(1, $readingTime),
            'status' => $data['status'],
            'is_featured' => $request->input('is_featured') ? 1 : 0,
            'is_sticky' => $request->input('is_sticky') ? 1 : 0,
            'published_at' => $data['status'] === 'published' ? date('Y-m-d H:i:s') : null
        ]);

        (new ActivityLog())->record((int)$user['id'], 'BLOG', 'CREATE', "Published blog article {$data['title']}", $request->ip());
        Flash::success("Blog post '{$data['title']}' created successfully.");
        $this->redirect(Url::to('/admin/content/blogs'));
    }

    public function autoSave(Request $request): void
    {
        $user = Session::get('user');
        $service = new BlogService();

        $res = $service->autoSaveDraft(
            (int)$user['id'],
            $request->input('post_id') ? (int)$request->input('post_id') : null,
            (string)$request->input('title', ''),
            (string)$request->input('content', ''),
            $request->input('category_id') ? (int)$request->input('category_id') : null
        );

        $this->json($res);
    }
}
