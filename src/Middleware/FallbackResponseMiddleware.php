<?php declare(strict_types=1);

namespace Ellipse\Http\Middleware;

use Psr\Http\Message\ResponseInterface;

use Ellipse\Exceptions\ExceptionHandlerMiddleware;
use Ellipse\Http\Handlers\FallbackRequestHandlerFactory;
use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

class FallbackResponseMiddleware extends ExceptionHandlerMiddleware
{
    /**
     * Set up an exception handler middleware catching middleware stack
     * exhausted exceptions and producing a response with a fallback request
     * handler using the given response prototype and debug mode.
     *
     * @param \Psr\Http\Message\ResponseInterface   $prototype
     * @param bool                                  $debug
     */
    public function __construct(ResponseInterface $prototype, bool $debug)
    {
        parent::__construct(MiddlewareStackExhaustedException::class, new FallbackRequestHandlerFactory($prototype, $debug));
    }
}
