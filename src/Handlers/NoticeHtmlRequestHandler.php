<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use League\Plates\Engine;

use Zend\Diactoros\Response\HtmlResponse;

class NoticeHtmlRequestHandler implements RequestHandlerInterface
{
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

        $html = $engine->render('notice');

        return new HtmlResponse($html, 404);
    }
}
