<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Middleware;
use App\Core\Request;
use App\Helpers\Logger;

class LogMiddleware implements Middleware
{
    public function handle(Request $request, \Closure $next, array $params = []): mixed
    {
        Logger::info("HTTP [{$request->getMethod()}] {$request->getUri()} - IP: {$request->ip()}");
        return $next($request);
    }
}
