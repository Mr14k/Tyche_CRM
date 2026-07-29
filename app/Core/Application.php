<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\ExceptionHandler;

class Application
{
    private Router $router;
    private Request $request;

    public function __construct()
    {
        // 1. Load Environment Configuration
        $root = dirname(__DIR__, 2);
        EnvLoader::load($root . '/.env');

        // 2. Register Centralized Exception Handler
        ExceptionHandler::register();

        // 3. Set Timezone
        date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Asia/Kolkata');

        // 4. Start Secure Session
        Session::start();

        // 5. Initialize Request & Router
        $this->request = new Request();
        $this->router = new Router();
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function run(): void
    {
        // Load web route definitions
        $router = $this->router;
        $routesPath = dirname(__DIR__, 2) . '/routes/web.php';
        if (file_exists($routesPath)) {
            require $routesPath;
        }

        // Dispatch request through router
        $this->router->dispatch($this->request);
    }
}
