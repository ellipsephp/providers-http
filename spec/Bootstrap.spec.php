<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Interop\Http\Factory\ResponseFactoryInterface;

use Ellipse\Dispatcher;
use Ellipse\DispatcherFactoryInterface;
use Ellipse\Http\Bootstrap;
use Ellipse\Http\Handlers\AppRequestHandler;

describe('Bootstrap', function () {

    beforeEach(function () {

        $this->container = mock(ContainerInterface::class);

        $this->bootstrap = new Bootstrap($this->container->get());

    });

    describe('->__invoke()', function () {

        beforeEach(function () {

            $factory = mock(DispatcherFactoryInterface::class);
            $middleware = [mock(MiddlewareInterface::class)->get()];
            $handler = mock(RequestHandlerInterface::class)->get();
            $this->dispatcher = mock(Dispatcher::class)->get();
            $this->factory = mock(ResponseFactoryInterface::class)->get();

            $this->container->get->with(DispatcherFactoryInterface::class)->returns($factory);
            $this->container->get->with('ellipse.http.middleware')->returns($middleware);
            $this->container->get->with('ellipse.http.handler')->returns($handler);
            $factory->__invoke->with($handler, $middleware)->returns($this->dispatcher);

        });

        context('when the given debug mode is set to false', function () {

            it('should return an AppRequestHandler wrapped around a dispatcher built from the container and the debug mode set to false', function () {

                $test = ($this->bootstrap)($this->factory, 'env', false);

                $handler = new AppRequestHandler($this->dispatcher, $this->factory, false);

                expect($test)->toEqual($handler);

            });

        });

        context('when the given debug mode is set to true', function () {

            it('should return an AppRequestHandler wrapped around a dispatcher built from the container and the debug mode set to true', function () {

                $test = ($this->bootstrap)($this->factory, 'env', true);

                $handler = new AppRequestHandler($this->dispatcher, $this->factory, true);

                expect($test)->toEqual($handler);

            });

        });

    });

});
