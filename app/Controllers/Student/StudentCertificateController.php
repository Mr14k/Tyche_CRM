<?php

declare(strict_types=1);

namespace App\Controllers\Student;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Certificate;
use App\Services\CertificateService;
use App\Helpers\Flash;
use App\Helpers\Url;

class StudentCertificateController extends Controller
{
    public function index(Request $request): void
    {
        $user = Session::get('user');
        $certificates = \App\Core\Database::fetchAll("SELECT cert.*, c.title as course_title, c.code as course_code 
            FROM certificates cert
            JOIN courses c ON cert.course_id = c.id
            WHERE cert.user_id = :uid", ['uid' => $user['id']]);

        $this->view('student.certificates', [
            'pageTitle' => 'My Earned Certificates — Tyche Academy',
            'certificates' => $certificates
        ], 'admin');
    }

    public function generate(Request $request, string $courseId): void
    {
        $user = Session::get('user');
        $service = new CertificateService();
        $cert = $service->issueCertificateIfEligible((int)$user['id'], (int)$courseId);

        if ($cert) {
            Flash::success("Official course completion certificate issued: {$cert['certificate_code']}");
        } else {
            Flash::error("Ineligible for certificate. Please ensure 100% video lesson completion and passed quizzes.");
        }

        $this->redirect(Url::to('/student/certificates'));
    }
}
