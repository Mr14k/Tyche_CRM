<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class AccessDeniedException extends Exception
{
    public function __construct(string $message = "Access Denied", int $code = 403)
    {
        parent::__construct($message, $code);
    }
}
