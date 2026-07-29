<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Blog;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Database;
use App\Models\BlogPost;
use App\Exceptions\NotFoundException;
use App\Helpers\Flash;
use App\Helpers\Url;

class BlogAdminController extends Controller
{
    private BlogPost $blogModel;

    public function __construct()
    {
        parent::__construct();
        $this->blogModel = new BlogPost();
    }

    public function index(Request $request): void
    {
        $posts = $this->blogModel->getAllWithDetails();
        $this->view('admin.blog.index', [
            'pageTitle' => 'Blog Engine & Article Publisher — Tyche Admin',
            'posts' => $posts
        ], 'admin');
    }

    public function create(Request $request): void
    {
        $categories = Database::fetchAll("SELECT * FROM blog_categories ORDER BY name ASC");
        $this->view('admin.blog.create', [
            'pageTitle' => 'Create New Blog Post — Tyche Admin',
            'categories' => $categories
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'title' => 'required|min:3',
            'content' => 'required'
        ]);

        $user = Session::get('user');
        $slug = strtolower(trim((string)preg_replace('/[^A-Za-z0-9-]+/', '-', $data['title']), '-'));
        
        // Ensure unique slug

        $existing = $this->blogModel->findBySlug($slug);
        if ($existing) {
            $slug .= '-' . rand(100, 999);
        }

        $summary = trim((string)$request->input('summary', ''));
        if ($summary === '') {
            $summary = substr(strip_tags($data['content']), 0, 160) . '...';
        }

        $wordCount = str_word_count(strip_tags($data['content']));
        $readingTime = max(1, (int)ceil($wordCount / 200));

        $status = $request->input('status', 'published');
        $publishedAt = ($status === 'published') ? date('Y-m-d H:i:s') : null;

        $this->blogModel->create([
            'title' => $data['title'],
            'slug' => $slug,
            'summary' => $summary,
            'content' => $data['content'],
            'featured_image' => trim((string)$request->input('featured_image', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80')),
            'category_id' => !empty($request->input('category_id')) ? (int)$request->input('category_id') : 1,
            'author_id' => (int)($user['id'] ?? 1),
            'reading_time_minutes' => $readingTime,
            'status' => $status,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_sticky' => $request->has('is_sticky') ? 1 : 0,
            'views_count' => 0,
            'published_at' => $publishedAt
        ]);

        Flash::success("Blog post '{$data['title']}' published successfully!");
        $this->redirect(Url::to('/admin/blog'));
    }

    public function edit(Request $request, string $id): void
    {
        $post = $this->blogModel->find((int)$id);
        if (!$post) {
            throw new NotFoundException("Blog post not found.");
        }

        $categories = Database::fetchAll("SELECT * FROM blog_categories ORDER BY name ASC");
        $this->view('admin.blog.edit', [
            'pageTitle' => "Edit Blog Post: {$post['title']} — Tyche Admin",
            'post' => $post,
            'categories' => $categories
        ], 'admin');
    }

    public function update(Request $request, string $id): void
    {
        $post = $this->blogModel->find((int)$id);
        if (!$post) {
            throw new NotFoundException("Blog post not found.");
        }

        $data = $this->validate($request, [
            'title' => 'required|min:3',
            'content' => 'required'
        ]);

        $summary = trim((string)$request->input('summary', ''));
        if ($summary === '') {
            $summary = substr(strip_tags($data['content']), 0, 160) . '...';
        }

        $wordCount = str_word_count(strip_tags($data['content']));
        $readingTime = max(1, (int)ceil($wordCount / 200));

        $status = $request->input('status', 'published');
        $publishedAt = ($status === 'published' && empty($post['published_at'])) ? date('Y-m-d H:i:s') : $post['published_at'];

        $this->blogModel->update((int)$id, [
            'title' => $data['title'],
            'summary' => $summary,
            'content' => $data['content'],
            'featured_image' => trim((string)$request->input('featured_image', $post['featured_image'])),
            'category_id' => !empty($request->input('category_id')) ? (int)$request->input('category_id') : (int)$post['category_id'],
            'reading_time_minutes' => $readingTime,
            'status' => $status,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_sticky' => $request->has('is_sticky') ? 1 : 0,
            'published_at' => $publishedAt
        ]);

        Flash::success("Blog post '{$data['title']}' updated successfully!");
        $this->redirect(Url::to('/admin/blog'));
    }

    public function delete(Request $request, string $id): void
    {
        $post = $this->blogModel->find((int)$id);
        if ($post) {
            $this->blogModel->delete((int)$id);
            Flash::success("Blog post '{$post['title']}' deleted.");
        }
        $this->redirect(Url::to('/admin/blog'));
    }
}
