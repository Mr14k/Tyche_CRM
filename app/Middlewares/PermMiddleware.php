<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Middleware;
use App\Core\Request;
use App\Services\RbacService;
use App\Exceptions\AccessDeniedException;

class PermMiddleware implements Middleware
{
    public function handle(Request $request, \Closure $next, array $params = []): mixed
    {
        $requiredPerm = $params[0] ?? '';
        if ($requiredPerm && !RbacService::hasPermission($requiredPerm)) {
            throw new AccessDeniedException("Access Denied: Missing permission '{$requiredPerm}'.");
        }
        return $next($request);
    }
}
