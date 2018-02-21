<?php declare(strict_types=1);

namespace Ellipse\Http\Handlers;

use Interop\Http\Factory\ResponseFactoryInterface;

class FallbackRequestHandlerFactory
{
    /**
     * The response factory.
     *
     * @var \Interop\Http\Factory\ResponseFactoryInterface
     */
    private $factory;

    /**
     * Whether the application is in debug mode or not.
     *
     * @var bool
     */
    private $debug;

    /**
     * Set up a fallback request handler factory with the given response factory
     * and debug mode.
     *
     * @param \Interop\Http\Factory\ResponseFactoryInterface    $factory
     * @param bool                                              $debug
     */
    public function __construct(ResponseFactoryInterface $factory, bool $debug)
    {
        $this->factory = $factory;
        $this->debug = $debug;
    }

    /**
     * Return a fallback request handler.
     *
     * @return \Ellipse\Http\Handlers\FallbackRequestHandler
     */
    public function __invoke(): FallbackRequestHandler
    {
        return new FallbackRequestHandler($this->factory, $this->debug);
    }
}
