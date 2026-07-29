<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Helpers\Url;

class GuestMiddleware implements Middleware
{
    public function handle(Request $request, \Closure $next, array $params = []): mixed
    {
        if (Session::has('user')) {
            (new Response())->redirect(Url::to('/dashboard'));
        }
        return $next($request);
    }
}
