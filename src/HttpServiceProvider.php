<?php declare(strict_types=1);

namespace Ellipse\Http;

use Psr\Container\ContainerInterface;

use Psr\Http\Server\RequestHandlerInterface;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Http\Handlers\DefaultRequestHandler;

class HttpServiceProvider implements ServiceProviderInterface
{
    /**
     * The user defined service extensions.
     *
     * @var array
     */
    private $extensions;

    /**
     * Set up a http service provider with the given extensions.
     *
     * @param array $extensions
     */
    public function __construct(array $extensions = [])
    {
        $this->extensions = $extensions;
    }

    /**
     * @inheritdoc
     */
    public function getFactories()
    {
        return [
            'ellipse.http.middleware' => [$this, 'getMiddleware'],
            'ellipse.http.handler' => [$this, 'getRequestHandler'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * Return an empty array as middleware queue.
     *
     * @param \Psr\Container\ContainerInterface $container
     * @return array
     */
    public function getMiddleware(ContainerInterface $container): array
    {
        return [];
    }

    /**
     * Return a default request handler as final request handler.
     *
     * @param \Psr\Container\ContainerInterface $container
     * @return \Psr\Http\Server\RequestHandlerInterface
     */
    public function getRequestHandler(ContainerInterface $container): RequestHandlerInterface
    {
        return new DefaultRequestHandler;
    }
}
