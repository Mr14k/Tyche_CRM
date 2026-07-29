<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Controller;
use App\Core\Request;

class HomeController extends Controller
{
    public function index(Request $request): void
    {
        $this->view('web.index', [
            'pageTitle' => 'Tyche — Digital Marketing Academy'
        ], 'web');
    }
}
