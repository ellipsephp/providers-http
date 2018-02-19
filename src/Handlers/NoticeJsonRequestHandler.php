<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Zend\Diactoros\Response\JsonResponse;

use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

class NoticeJsonRequestHandler implements RequestHandlerInterface
{
    /**
     * Return a notice json response.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $msg = "This is the default request handler. This means no middleware produced a response before hitting it.";

        return new JsonResponse([
            'type' => MiddlewareStackExhaustedException::class,
            'message' => $msg,
        ], 404);
    }
}
