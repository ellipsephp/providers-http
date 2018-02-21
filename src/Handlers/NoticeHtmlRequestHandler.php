<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use League\Plates\Engine;

use Interop\Http\Factory\ResponseFactoryInterface;

class NoticeHtmlRequestHandler implements RequestHandlerInterface
{
    /**
     * The response factory.
     *
     * @var \Interop\Http\Factory\ResponseFactoryInterface
     */
    private $factory;

    /**
     * Set up a notice html request handler with the given response factory.
     *
     * @param \Interop\Http\Factory\ResponseFactoryInterface $factory
     */
    public function __construct(ResponseFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Return a notice html response.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $path = realpath(__DIR__ . '/../../templates');

        $engine = new Engine($path);

        $contents = $engine->render('notice');

        $response = $this->factory
            ->createResponse(404)
            ->withHeader('Content-type', 'text/html');

        $response->getBody()->write($contents);

        return $response;
    }
}
