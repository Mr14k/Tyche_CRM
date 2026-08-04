<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\TenantContext;
use App\Models\Tenant;
use Closure;

class TenantMiddleware implements Middleware
{
    public function handle(Request $request, Closure $next, array $params = []): mixed
    {
        $tenantModel = new Tenant();
        $tenantId = 1;
        $tenantData = null;

        // Security Enforcement: If user is logged in and NOT Super SaaS Admin (Tenant 1), lock strictly to assigned tenant_id
        if (!empty($_SESSION['user']['tenant_id']) && (int)$_SESSION['user']['tenant_id'] !== 1) {
            $tenantId = (int)$_SESSION['user']['tenant_id'];
            $_SESSION['tenant_id'] = $tenantId;
            $tenantData = $tenantModel->find($tenantId);
            TenantContext::setTenantId($tenantId, $tenantData);
            return $next($request);
        }

        // 1. Check for explicit query override (?tenant=subdomain or ?t=subdomain or ?tenant_id=X) — Super Admin Workspace Switcher
        $override = $request->get('tenant') ?? $request->get('t') ?? $request->get('tenant_id');
        if ($override) {
            $matched = is_numeric($override) ? $tenantModel->find((int)$override) : $tenantModel->findBySubdomain((string)$override);
            if ($matched && $matched['status'] === 'active') {
                $tenantId = (int)$matched['id'];
                $tenantData = $matched;
                $_SESSION['tenant_id'] = $tenantId;
            }
        } else {
            // 2. Check HTTP Host header (e.g., alpha.tycheapp.com -> alpha)
            $host = $_SERVER['HTTP_HOST'] ?? '';
            $parts = explode('.', $host);
            
            if (count($parts) >= 2 && $parts[0] !== 'localhost' && $parts[0] !== 'www' && $parts[0] !== '127') {
                $subdomain = strtolower($parts[0]);
                $matched = $tenantModel->findBySubdomain($subdomain);
                if ($matched && $matched['status'] === 'active') {
                    $tenantId = (int)$matched['id'];
                    $tenantData = $matched;
                    $_SESSION['tenant_id'] = $tenantId;
                }
            }
            
            // 3. Fallback to active session tenant or user tenant if set
            if ($tenantData === null && !empty($_SESSION['user']['tenant_id'])) {
                $tenantId = (int)$_SESSION['user']['tenant_id'];
                $_SESSION['tenant_id'] = $tenantId;
                $tenantData = $tenantModel->find($tenantId);
            } elseif ($tenantData === null && !empty($_SESSION['tenant_id'])) {
                $sessionTenantId = (int)$_SESSION['tenant_id'];
                $matched = $tenantModel->find($sessionTenantId);
                if ($matched && $matched['status'] === 'active') {
                    $tenantId = (int)$matched['id'];
                    $tenantData = $matched;
                }
            }
        }

        if ($tenantData === null) {
            $tenantData = $tenantModel->find($tenantId);
        }

        // Set global request tenant context
        TenantContext::setTenantId($tenantId, $tenantData);

        return $next($request);
    }
}
