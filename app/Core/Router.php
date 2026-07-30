<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\NotFoundException;

class Router
{
    private array $routes = [];
    private array $namedRoutes = [];
    private array $groupStack = [];

    public function get(string $path, array|callable $handler): self
    {
        return $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array|callable $handler): self
    {
        return $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, array|callable $handler): self
    {
        return $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, array|callable $handler): self
    {
        return $this->addRoute('DELETE', $path, $handler);
    }

    public function group(array $attributes, callable $callback): void
    {
        $this->groupStack[] = $attributes;
        call_user_func($callback, $this);
        array_pop($this->groupStack);
    }

    private function addRoute(string $method, string $path, array|callable $handler): self
    {
        $prefix = '';
        $middlewares = [];

        foreach ($this->groupStack as $group) {
            if (isset($group['prefix'])) {
                $prefix .= '/' . trim($group['prefix'], '/');
            }
            if (isset($group['middleware'])) {
                $groupMw = is_array($group['middleware']) ? $group['middleware'] : [$group['middleware']];
                $middlewares = array_merge($middlewares, $groupMw);
            }
        }

        $fullPath = '/' . trim($prefix . '/' . trim($path, '/'), '/');

        $route = [
            'method' => strtoupper($method),
            'path' => $fullPath,
            'regex' => $this->convertPathToRegex($fullPath),
            'handler' => $handler,
            'middleware' => $middlewares,
            'name' => null
        ];

        $this->routes[] = $route;
        return $this;
    }

    public function name(string $name): self
    {
        $lastIndex = count($this->routes) - 1;
        if ($lastIndex >= 0) {
            $this->routes[$lastIndex]['name'] = $name;
            $this->namedRoutes[$name] = $this->routes[$lastIndex]['path'];
        }
        return $this;
    }

    public function middleware(string|array $middleware): self
    {
        $lastIndex = count($this->routes) - 1;
        if ($lastIndex >= 0) {
            $mw = is_array($middleware) ? $middleware : [$middleware];
            $this->routes[$lastIndex]['middleware'] = array_merge(
                $this->routes[$lastIndex]['middleware'],
                $mw
            );
        }
        return $this;
    }

    public function getUrlByName(string $name, array $params = []): string
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new \Exception("Route name '{$name}' not found.");
        }

        $url = $this->namedRoutes[$name];
        foreach ($params as $key => $value) {
            $url = str_replace('{' . $key . '}', (string)$value, $url);
        }
        return $url;
    }

    public function dispatch(Request $request): mixed
    {
        $method = $request->getMethod();
        $uri = $request->getUri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['regex'], $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return $this->runMiddlewareStack($route['middleware'], $request, function() use ($route, $request, $params) {
                    return $this->executeHandler($route['handler'], $request, $params);
                });
            }
        }

        throw new NotFoundException("Route not found: [{$method}] {$uri}");
    }

    private function convertPathToRegex(string $path): string
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function runMiddlewareStack(array $middlewares, Request $request, callable $destination): mixed
    {
        $pipeline = array_reduce(
            array_reverse($middlewares),
            function ($next, $middlewareStr) {
                return function ($request) use ($next, $middlewareStr) {
                    list($name, $argsStr) = array_pad(explode(':', $middlewareStr, 2), 2, null);
                    $args = $argsStr ? explode(',', $argsStr) : [];
                    
                    $middlewareClass = $this->resolveMiddlewareClass($name);
                    $instance = new $middlewareClass();
                    return $instance->handle($request, $next, $args);
                };
            },
            $destination
        );

        return $pipeline($request);
    }

    private function resolveMiddlewareClass(string $name): string
    {
        $map = [
            'auth' => \App\Middlewares\AuthMiddleware::class,
            'guest' => \App\Middlewares\GuestMiddleware::class,
            'role' => \App\Middlewares\RoleMiddleware::class,
            'perm' => \App\Middlewares\PermMiddleware::class,
            'csrf' => \App\Middlewares\CsrfMiddleware::class,
            'log' => \App\Middlewares\LogMiddleware::class,
            'tenant' => \App\Middlewares\TenantMiddleware::class,
        ];

        return $map[$name] ?? $name;
    }

    private function executeHandler(array|callable $handler, Request $request, array $params): mixed
    {
        if (is_callable($handler)) {
            return call_user_func_array($handler, array_merge([$request], $params));
        }

        if (is_array($handler) && count($handler) === 2) {
            list($controllerClass, $method) = $handler;
            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller class {$controllerClass} not found.");
            }
            $controller = new $controllerClass();
            if (!method_exists($controller, $method)) {
                throw new \Exception("Method {$method} not found in {$controllerClass}.");
            }
            return call_user_func_array([$controller, $method], array_merge([$request], $params));
        }

        throw new \Exception("Invalid route handler provided.");
    }
}
