<?php declare(strict_types=1);

namespace Ellipse\Http\Middleware;

use Interop\Http\Factory\ResponseFactoryInterface;

use Ellipse\Exceptions\ExceptionHandlerMiddleware;
use Ellipse\Http\Handlers\FallbackRequestHandlerFactory;
use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

class FallbackResponseMiddleware extends ExceptionHandlerMiddleware
{
    /**
     * Set up an exception handler middleware catching middleware stack
     * exhausted exceptions and producing a response with a fallback request
     * handler using the given response factory and debug mode.
     *
     * @param \Interop\Http\Factory\ResponseFactoryInterface    $factory
     * @param bool                                              $debug
     */
    public function __construct(ResponseFactoryInterface $factory, bool $debug)
    {
        parent::__construct(MiddlewareStackExhaustedException::class, new FallbackRequestHandlerFactory($factory, $debug));
    }
}
