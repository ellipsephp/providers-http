<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use League\Plates\Engine;

class NoticeHtmlRequestHandler implements RequestHandlerInterface
{
    /**
     * The response prototype.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $prototype;

    /**
     * Set up a notice html request handler with the given response prototype.
     *
     * @param \Psr\Http\Message\ResponseInterface $prototype
     */
    public function __construct(ResponseInterface $prototype)
    {
        $this->prototype = $prototype;
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

        $this->prototype->getBody()->write($contents);

        return $this->prototype
            ->withStatus(404)
            ->withHeader('Content-type', 'text/html');
    }
}
