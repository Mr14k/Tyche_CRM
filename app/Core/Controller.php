<?php

declare(strict_types=1);

namespace App\Core;

use App\Helpers\Security;

abstract class Controller
{
    protected Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    protected function view(string $viewPath, array $data = [], string $layout = 'web'): void
    {
        View::render($viewPath, $data, $layout);
    }

    protected function json(mixed $data, int $statusCode = 200): void
    {
        $this->response->json($data, $statusCode);
    }

    protected function redirect(string $url, int $statusCode = 302): void
    {
        $this->response->redirect($url, $statusCode);
    }

    protected function validate(Request $request, array $rules): array
    {
        return \App\Helpers\ValidationEngine::validate($request->all(), $rules);
    }

    protected function generateCsrfToken(): string
    {
        return Security::csrfToken();
    }
}
