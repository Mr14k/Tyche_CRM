<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Page;
use App\Models\SeoMetadata;
use App\Services\FormSubmissionService;
use App\Exceptions\NotFoundException;
use App\Helpers\Flash;
use App\Helpers\Url;

class CmsPageController extends Controller
{
    private Page $pageModel;
    private SeoMetadata $seoModel;

    public function __construct()
    {
        parent::__construct();
        $this->pageModel = new Page();
        $this->seoModel = new SeoMetadata();
    }

    public function show(Request $request, string $slug): void
    {
        $page = $this->pageModel->findBySlug($slug);
        if (!$page || $page['status'] !== 'published') {
            throw new NotFoundException("The requested page '{$slug}' could not be found.");
        }

        $seo = $this->seoModel->findForEntity('page', (int)$page['id']);

        $this->view('web.page', [
            'pageTitle' => $seo['meta_title'] ?? $page['title'],
            'page' => $page,
            'seo' => $seo
        ], 'web');
    }

    public function contact(Request $request): void
    {
        $this->view('web.contact', [
            'pageTitle' => 'Contact Us & Admissions Office — Tyche Academy'
        ], 'web');
    }

    public function privacy(Request $request): void
    {
        $this->view('web.privacy', [
            'pageTitle' => 'Privacy Policy — Tyche Academy'
        ], 'web');
    }

    public function terms(Request $request): void
    {
        $this->view('web.terms', [
            'pageTitle' => 'Terms of Service — Tyche Academy'
        ], 'web');
    }

    public function verifyInvoice(Request $request): void
    {
        $query = trim((string)$request->input('query', ''));
        $invoice = null;
        $searched = false;

        if ($query !== '') {
            $searched = true;
            $sql = "SELECT inv.*, u.first_name, u.last_name, u.email, p.payment_reference, p.gateway
                    FROM invoices inv
                    JOIN users u ON inv.user_id = u.id
                    JOIN payments p ON inv.payment_id = p.id
                    WHERE inv.invoice_number = :q OR p.payment_reference = :q
                    LIMIT 1";
            $invoice = \App\Core\Database::fetchOne($sql, ['q' => $query]);
        }

        $this->view('web.verify_invoice', [
            'pageTitle' => '18% GST Invoice Lookup & Verification — Tyche Academy',
            'query' => $query,
            'invoice' => $invoice,
            'searched' => $searched
        ], 'web');
    }

    public function processForm(Request $request): void
    {
        $data = $this->validate($request, [
            'form_type' => 'required',
            'email' => 'required|email'
        ]);

        $service = new FormSubmissionService();
        $service->submitForm($data['form_type'], $data, $request->ip(), $request->userAgent());

        if ($request->isAjax()) {
            $this->json(['success' => true, 'message' => 'Thank you! Your inquiry has been received.']);
        }

        Flash::success('Thank you! Your inquiry has been submitted to our admissions team.');
        $referer = $_SERVER['HTTP_REFERER'] ?? Url::to('/');
        $this->redirect($referer);
    }

    public function processNewsletter(Request $request): void
    {
        $email = $request->input('email');
        $service = new FormSubmissionService();
        $service->subscribeNewsletter((string)$email);

        if ($request->isAjax()) {
            $this->json(['success' => true, 'message' => 'Subscribed successfully!']);
        }

        Flash::success('You have successfully subscribed to the Tyche Academy newsletter.');
        $this->redirect(Url::to('/'));
    }
}
