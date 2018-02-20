<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Dispatcher\RequestHandlerWithMiddlewareStack;
use Ellipse\Http\Middleware\FallbackResponseMiddleware;

class AppRequestHandler extends RequestHandlerWithMiddlewareStack
{
    public function __construct(RequestHandlerInterface $handler, ResponseInterface $prototype, bool $debug)
    {
        parent::__construct($handler, [new FallbackResponseMiddleware($prototype, $debug)]);
    }
}
