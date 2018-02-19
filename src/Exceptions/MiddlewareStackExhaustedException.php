<?php declare(strict_types=1);

namespace Ellipse\Http\Exceptions;

use RuntimeException;

class MiddlewareStackExhaustedException extends RuntimeException implements HttpExceptionInterface
{
    public function __construct()
    {
        $msg = "Middleware stack exhausted without returning a response";

        parent::__construct($msg);
    }
}
