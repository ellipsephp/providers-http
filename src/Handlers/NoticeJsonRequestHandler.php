<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

class NoticeJsonRequestHandler implements RequestHandlerInterface
{
    /**
     * The response prototype.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $prototype;

    /**
     * Set up a notice json request handler with the given response prototype.
     *
     * @param \Psr\Http\Message\ResponseInterface $prototype
     */
    public function __construct(ResponseInterface $prototype)
    {
        $this->prototype = $prototype;
    }

    /**
     * Return a notice json response.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $msg = "This is the default request handler. This means no middleware produced a response before hitting it.";

        $contents = json_encode([
            'type' => MiddlewareStackExhaustedException::class,
            'message' => $msg,
        ]);

        $this->prototype->getBody()->write($contents);

        return $this->prototype
            ->withStatus(404)
            ->withHeader('Content-type', 'application/json');
    }
}
