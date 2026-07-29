<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Helpers\Url;
use App\Helpers\Flash;

class AuthMiddleware implements Middleware
{
    public function handle(Request $request, \Closure $next, array $params = []): mixed
    {
        if (!Session::has('user')) {
            if ($request->isAjax()) {
                (new Response())->json(['error' => 'Unauthenticated access.'], 401);
            }
            Flash::error('Please log in to access this page.');
            (new Response())->redirect(Url::to('/login'));
        }
        return $next($request);
    }
}
