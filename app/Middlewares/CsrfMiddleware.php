<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\Response;
use App\Helpers\Security;
use Closure;

class CsrfMiddleware implements Middleware
{
    public function handle(Request $request, Closure $next, array $params = []): mixed
    {
        $method = $request->getMethod();
        if (in_array($method, ['POST', 'PUT', 'DELETE'], true)) {
            $token = $request->input('_token') ?? $request->input('csrf_token') ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            if (!Security::verifyCsrfToken($token)) {
                if ($request->isAjax()) {
                    (new Response())->json(['error' => 'CSRF Token Mismatch'], 419);
                }
                throw new \Exception("CSRF Token Mismatch or Expiry.", 419);
            }
        }
        return $next($request);
    }
}
