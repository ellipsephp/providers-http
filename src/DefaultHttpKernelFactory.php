<?php declare(strict_types=1);

namespace Ellipse\Http;

use Psr\Container\ContainerInterface;

class DefaultHttpKernelFactory extends HttpKernelFactory
{
    /**
     * Set up a default http kernel factory using the given application
     * container.
     *
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct(new Bootstrap($container));
    }
}
