<?php declare(strict_types=1);

namespace Ellipse\Http\Middleware;

use Ellipse\Exceptions\ExceptionHandlerMiddleware;
use Ellipse\Http\Handlers\FallbackRequestHandlerFactory;
use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

class FallbackResponseMiddleware extends ExceptionHandlerMiddleware
{
    /**
     * Set up an exception handler middleware catching middleware stack
     * exhausted exceptions and producing a response with a fallback request
     * handler.
     *
     * @param bool $debug
     */
    public function __construct(bool $debug)
    {
        parent::__construct(MiddlewareStackExhaustedException::class, new FallbackRequestHandlerFactory($debug));
    }
}
