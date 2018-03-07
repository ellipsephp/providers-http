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
     * Return the prefixed version of the given id.
     *
     * @param string $id
     * @return string
     */
    private function prefixed(string $id): string
    {
        return sprintf('ellipse.http.%s', $id);
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
        $ids = array_keys($this->extensions);
        $callables = array_values($this->extensions);

        $prefixed = array_map([$this, 'prefixed'], $ids);

        return array_combine($prefixed, $callables);
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
