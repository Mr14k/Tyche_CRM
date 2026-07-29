<?php

return [
    'name' => $_ENV['APP_NAME'] ?? 'Tyche — Digital Marketing Academy',
    'env' => $_ENV['APP_ENV'] ?? 'development',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? true, FILTER_VALIDATE_BOOLEAN),
    'url' => $_ENV['APP_URL'] ?? 'http://localhost/tyche',
    'timezone' => $_ENV['APP_TIMEZONE'] ?? 'Asia/Kolkata',
];
