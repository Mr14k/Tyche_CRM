<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Cms;

use App\Core\Controller;
use App\Core\Request;
use App\Models\FormSubmission;
use App\Models\NewsletterSubscriber;

class FormController extends Controller
{
    public function index(Request $request): void
    {
        $submissions = (new FormSubmission())->all();
        $subscribers = (new NewsletterSubscriber())->all();

        $this->view('admin.cms.forms', [
            'pageTitle' => 'Form Submissions & Subscribers — Tyche Academy',
            'submissions' => $submissions,
            'subscribers' => $subscribers
        ], 'admin');
    }
}
