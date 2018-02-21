<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Interop\Http\Factory\ResponseFactoryInterface;

class NotFoundJsonRequestHandler implements RequestHandlerInterface
{
    /**
     * The response factory.
     *
     * @var \Interop\Http\Factory\ResponseFactoryInterface
     */
    private $factory;

    /**
     * Set up a not found json request handler with the given response
     * factory.
     *
     * @param \Interop\Http\Factory\ResponseFactoryInterface $factory
     */
    public function __construct(ResponseFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Return a not found json response.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $contents = json_encode(['message' => 'Not found']);

        $response = $this->factory
            ->createResponse(404)
            ->withHeader('Content-type', 'application/json');

        $response->getBody()->write($contents);

        return $response;
    }
}
