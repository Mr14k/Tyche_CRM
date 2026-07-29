<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use App\Core\Response;
use App\Core\View;
use App\Core\Request;
use App\Helpers\Logger;
use App\Helpers\Flash;

class ExceptionHandler
{
    public static function register(): void
    {
        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
    }

    public static function handleError(int $level, string $message, string $file = '', int $line = 0): bool
    {
        if (error_reporting() & $level) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
        return true;
    }

    public static function handleException(Throwable $e): void
    {
        $request = new Request();
        $response = new Response();

        // 1. Log error details
        Logger::error($e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'code' => $e->getCode(),
            'trace' => $e->getTraceAsString()
        ]);

        // 2. Handle ValidationException specially
        if ($e instanceof ValidationException) {
            if ($request->isAjax()) {
                $response->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->getErrors()
                ], 422);
            }

            foreach ($e->getErrors() as $fieldErrors) {
                foreach ($fieldErrors as $err) {
                    Flash::error($err);
                }
            }
            $referer = $_SERVER['HTTP_REFERER'] ?? \App\Helpers\Url::to('/');
            $response->redirect($referer);
        }

        // 3. Determine HTTP Code
        $code = 500;
        if ($e instanceof NotFoundException) {
            $code = 404;
        } elseif ($e instanceof AccessDeniedException) {
            $code = 403;
        }

        http_response_code($code);

        if ($request->isAjax()) {
            $response->json([
                'success' => false,
                'error' => $e->getMessage()
            ], $code);
        }

        $isDebug = filter_var($_ENV['APP_DEBUG'] ?? true, FILTER_VALIDATE_BOOLEAN);

        // Render appropriate error view
        try {
            View::render("errors.{$code}", [
                'exception' => $e,
                'isDebug' => $isDebug
            ], 'none');
        } catch (Throwable $renderErr) {
            echo "<h1>Error {$code}</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
        }
        exit;
    }
}
