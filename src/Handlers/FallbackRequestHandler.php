<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Psr\Http\Message\ResponseInterface;

class FallbackRequestHandler extends RequestBasedRequestHandler
{
    /**
     * Set up a fallback request handler with the given response prototype and
     * debug mode.
     *
     * @param bool $debug
     */
    public function __construct(ResponseInterface $prototype, bool $debug)
    {
        parent::__construct([
            'text/html' => $debug
                ? new NoticeHtmlRequestHandler($prototype)
                : new NotFoundHtmlRequestHandler($prototype),
            'application/json' => $debug
                ? new NoticeJsonRequestHandler($prototype)
                : new NotFoundJsonRequestHandler($prototype),
        ]);
    }
}
