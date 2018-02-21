<?php declare(strict_types=1);

namespace Ellipse\Http;

use Psr\Container\ContainerInterface;

use Interop\Http\Factory\ResponseFactoryInterface;

use Ellipse\DispatcherFactoryInterface;
use Ellipse\Http\Handlers\AppRequestHandler;

class Bootstrap
{
    /**
     * The application container.
     *
     * @var \Psr\Container\ContainerInterface
     */
    private $container;

    /**
     * Set up the bootstrap with the given application container.
     *
     * @param \Psr\Container\ContainerInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Return an AppRequestHandler wrapped around a dispatcher built with the
     * application container.
     *
     * @param \Psr\Http\Message\ResponseFactoryInterface    $factory
     * @param string                                        $env
     * @param bool                                          $debug
     * @return \Ellipse\Http\Handlers\AppRequestHandler
     */
    public function __invoke(ResponseFactoryInterface $factory, string $env, bool $debug): AppRequestHandler
    {
        $dispatcher = $this->container->get(DispatcherFactoryInterface::class);
        $middleware = $this->container->get('ellipse.http.middleware');
        $handler = $this->container->get('ellipse.http.handler');

        return new AppRequestHandler($dispatcher($handler, $middleware), $factory, $debug);
    }
}
