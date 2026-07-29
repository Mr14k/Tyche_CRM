<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Middleware;
use App\Core\Request;
use App\Services\RbacService;
use App\Exceptions\AccessDeniedException;

class RoleMiddleware implements Middleware
{
    public function handle(Request $request, \Closure $next, array $params = []): mixed
    {
        $requiredRole = $params[0] ?? '';
        if ($requiredRole && !RbacService::hasRole($requiredRole)) {
            throw new AccessDeniedException("Access Denied: Missing role '{$requiredRole}'.");
        }
        return $next($request);
    }
}
