<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    private array $queryParams;
    private array $bodyParams;
    private array $serverParams;
    private array $fileParams;

    public function __construct()
    {
        $this->queryParams = $_GET;
        $this->bodyParams = $_POST;
        $this->serverParams = $_SERVER;
        $this->fileParams = $_FILES;

        // Parse JSON payloads if Content-Type is application/json
        $contentType = $this->serverParams['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            $rawInput = file_get_contents('php://input');
            $jsonData = json_decode($rawInput, true);
            if (is_array($jsonData)) {
                $this->bodyParams = array_merge($this->bodyParams, $jsonData);
            }
        }
    }

    public function getMethod(): string
    {
        $method = strtoupper($this->serverParams['REQUEST_METHOD'] ?? 'GET');
        if ($method === 'POST' && isset($this->bodyParams['_method'])) {
            $method = strtoupper($this->bodyParams['_method']);
        }
        return $method;
    }

    public function getUri(): string
    {
        $uri = $this->serverParams['REQUEST_URI'] ?? '/';
        
        // Strip base folder /tyche if app is hosted in subfolder
        $scriptName = $this->serverParams['SCRIPT_NAME'] ?? '';
        $baseFolder = dirname(dirname($scriptName)); // e.g. /tyche
        if ($baseFolder !== '/' && $baseFolder !== '\\' && str_starts_with($uri, $baseFolder)) {
            $uri = substr($uri, strlen($baseFolder));
        }

        // Strip query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        return '/' . trim($uri, '/');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->queryParams[$key] ?? $this->bodyParams[$key] ?? $default;
    }

    public function query(string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->queryParams;
        }
        return $this->queryParams[$key] ?? $default;
    }

    public function input(string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->bodyParams;
        }
        return $this->bodyParams[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->queryParams, $this->bodyParams);
    }

    public function file(string $key): ?array
    {
        return $this->fileParams[$key] ?? null;
    }

    public function isAjax(): bool
    {
        return isset($this->serverParams['HTTP_X_REQUESTED_WITH']) &&
            strtolower($this->serverParams['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function ip(): string
    {
        return $this->serverParams['HTTP_CLIENT_IP'] ??
            $this->serverParams['HTTP_X_FORWARDED_FOR'] ??
            $this->serverParams['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    public function userAgent(): string
    {
        return $this->serverParams['HTTP_USER_AGENT'] ?? 'Unknown';
    }
}
