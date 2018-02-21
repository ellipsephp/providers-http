<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Psr\Http\Server\RequestHandlerInterface;

use Interop\Http\Factory\ResponseFactoryInterface;

use Ellipse\Dispatcher\RequestHandlerWithMiddlewareStack;
use Ellipse\Http\Middleware\FallbackResponseMiddleware;

class AppRequestHandler extends RequestHandlerWithMiddlewareStack
{
    /**
     * Set up an app request handler with the given requets handler and response
     * factory.
     *
     * @param \Psr\Http\Server\RequestHandlerInterface          $handler
     * @param \Interop\Http\Factory\ResponseFactoryInterface    $factory
     */
    public function __construct(RequestHandlerInterface $handler, ResponseFactoryInterface $factory, bool $debug)
    {
        parent::__construct($handler, [new FallbackResponseMiddleware($factory, $debug)]);
    }
}
