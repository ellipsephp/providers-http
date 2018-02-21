<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Interop\Http\Factory\ResponseFactoryInterface;

class FallbackRequestHandler extends RequestBasedRequestHandler
{
    /**
     * Set up a fallback request handler with the given response factory and
     * debug mode.
     *
     * @param \Interop\Http\Factory\ResponseFactoryInterface    $factory
     * @param bool                                              $debug
     */
    public function __construct(ResponseFactoryInterface $factory, bool $debug)
    {
        parent::__construct([
            'text/html' => $debug
                ? new NoticeHtmlRequestHandler($factory)
                : new NotFoundHtmlRequestHandler($factory),
            'application/json' => $debug
                ? new NoticeJsonRequestHandler($factory)
                : new NotFoundJsonRequestHandler($factory),
        ]);
    }
}
