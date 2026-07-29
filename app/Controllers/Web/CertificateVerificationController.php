<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Certificate;
use App\Exceptions\NotFoundException;

class CertificateVerificationController extends Controller
{
    private Certificate $certModel;

    public function __construct()
    {
        parent::__construct();
        $this->certModel = new Certificate();
    }

    public function verify(Request $request, string $code): void
    {
        $certificate = $this->certModel->findByCode($code);
        if (!$certificate) {
            throw new NotFoundException("Invalid or non-existent certificate code.");
        }

        $this->view('web.certificate_verify', [
            'pageTitle' => "Verify Certificate: {$certificate['certificate_code']} — Tyche Academy",
            'certificate' => $certificate
        ], 'web');
    }
}
