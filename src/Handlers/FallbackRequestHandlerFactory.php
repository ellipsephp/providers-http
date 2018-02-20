<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Psr\Http\Message\ResponseInterface;

class FallbackRequestHandlerFactory
{
    /**
     * The response prototype.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $prototype;

    /**
     * Whether the application is in debug mode or not.
     *
     * @var bool
     */
    private $debug;

    /**
     * Set up a fallback request handler factory with the given response
     * prototype and debug mode.
     *
     * @param \Psr\Http\Message\ResponseInterface   $prototype
     * @param bool                                  $debug
     */
    public function __construct(ResponseInterface $prototype, bool $debug)
    {
        $this->prototype = $prototype;
        $this->debug = $debug;
    }

    /**
     * Return a fallback request handler.
     *
     * @return \Ellipse\Http\Handlers\FallbackRequestHandler
     */
    public function __invoke(): FallbackRequestHandler
    {
        return new FallbackRequestHandler($this->prototype, $this->debug);
    }
}
