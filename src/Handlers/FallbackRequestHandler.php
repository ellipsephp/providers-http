<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Negotiation\Negotiator;

class FallbackRequestHandler extends RequestBasedRequestHandler
{
    /**
     * Set up a fallback request handler with the given mediatype negotiator and
     * debug status.
     *
     * @param \Negotiation\Negotiator   $negotiator
     * @param bool                      $debug
     */
    public function __construct(Negotiator $negotiator, bool $debug)
    {
        parent::__construct($negotiator, [
            'text/html' => $debug
                ? new NoticeHtmlRequestHandler
                : new NotFoundHtmlRequestHandler,
            'application/json' => $debug
                ? new NoticeJsonRequestHandler
                : new NotFoundJsonRequestHandler,
        ]);
    }
}
