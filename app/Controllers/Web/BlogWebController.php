<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Controller;
use App\Core\Request;
use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Models\Event;
use App\Exceptions\NotFoundException;

class BlogWebController extends Controller
{
    private BlogPost $postModel;

    public function __construct()
    {
        parent::__construct();
        $this->postModel = new BlogPost();
    }

    public function index(Request $request): void
    {
        $posts = $this->postModel->getPublishedWithCategory();
        $this->view('web.blog.index', [
            'pageTitle' => 'Blog & Digital Marketing Insights — Tyche Academy',
            'posts' => $posts
        ], 'web');
    }

    public function show(Request $request, string $slug): void
    {
        $post = $this->postModel->findBySlug($slug);
        if (!$post || $post['status'] !== 'published') {
            throw new NotFoundException("Article not found.");
        }

        // Increment views count
        \App\Core\Database::execute("UPDATE blog_posts SET views_count = views_count + 1 WHERE id = :id", ['id' => $post['id']]);

        $this->view('web.blog.show', [
            'pageTitle' => $post['title'] . ' — Tyche Academy Blog',
            'post' => $post
        ], 'web');
    }

    public function caseStudies(Request $request): void
    {
        $studies = (new CaseStudy())->all();
        $this->view('web.blog.case_studies', [
            'pageTitle' => 'Client Case Studies & Performance Results — Tyche Academy',
            'studies' => $studies
        ], 'web');
    }

    public function events(Request $request): void
    {
        $events = (new Event())->getUpcoming();
        $this->view('web.blog.events', [
            'pageTitle' => 'Upcoming Masterclasses & Live Webinars — Tyche Academy',
            'events' => $events
        ], 'web');
    }
}
