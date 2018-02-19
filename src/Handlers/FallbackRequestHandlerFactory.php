<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Negotiation\Negotiator;

class FallbackRequestHandlerFactory extends RequestBasedRequestHandler
{
    /**
     * Whether the application is in debug mode or not.
     *
     * @var bool
     */
    private $debug;

    /**
     * Set up a fallback request handler factory with the given debug status.
     *
     * @param bool $debug
     */
    public function __construct(bool $debug)
    {
        $this->debug = $debug;
    }

    /**
     * Return a fallback request handler.
     *
     * @return \Ellipse\Http\Handlers\FallbackRequestHandler
     */
    public function __invoke(): FallbackRequestHandler
    {
        $negotiator = new Negotiator;

        return new FallbackRequestHandler($negotiator, $this->debug);
    }
}
