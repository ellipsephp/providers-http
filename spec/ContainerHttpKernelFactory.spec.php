<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Interop\Http\Factory\ResponseFactoryInterface;

use Ellipse\Dispatcher;
use Ellipse\DispatcherFactoryInterface;
use Ellipse\Http\HttpKernelFactory;
use Ellipse\Http\ContainerHttpKernelFactory;
use Ellipse\Http\HttpKernelWithBootFailure;
use Ellipse\Http\HttpKernelWithoutBootFailure;
use Ellipse\Http\Handlers\AppRequestHandler;

describe('ContainerHttpKernelFactory', function () {

    beforeEach(function () {

        $this->container = mock(ContainerInterface::class);

        $this->kernel = new ContainerHttpKernelFactory($this->container->get());

    });

    it('should extend HttpKernelFactory', function () {

        expect($this->kernel)->toBeAnInstanceOf(HttpKernelFactory::class);

    });

    describe('->__invoke()', function () {

        beforeEach(function () {

            $this->middleware = [mock(MiddlewareInterface::class)->get()];
            $this->handler = mock(RequestHandlerInterface::class)->get();
            $this->dfactory = mock(DispatcherFactoryInterface::class);
            $this->dispatcher = mock(Dispatcher::class)->get();
            $this->factory = mock(ResponseFactoryInterface::class)->get();

            $this->container->get->with(DispatcherFactoryInterface::class)->returns($this->dfactory);
            $this->container->get->with('ellipse.http.middleware')->returns($this->middleware);
            $this->container->get->with('ellipse.http.handler')->returns($this->handler);

        });

        context('when the container does not throw an exception', function () {

            beforeEach(function () {

                $this->dfactory->__invoke->with($this->handler, $this->middleware)->returns($this->dispatcher);

            });

            context('when the given debug mode is false', function () {

                it('should return a HttpKernelWithoutBootFailure wrapped around the produced AppRequestHandler with debug mode to false', function () {

                    $test = ($this->kernel)($this->factory, 'env', false);

                    $kernel = new HttpKernelWithoutBootFailure(
                        new AppRequestHandler($this->dispatcher, $this->factory, false),
                        $this->factory,
                        false
                    );

                    expect($test)->toEqual($kernel);

                });

            });

            context('when the given debug mode is true', function () {

                it('should return a HttpKernelWithoutBootFailure wrapped around the produced AppRequestHandler with debug mode to true', function () {

                    $test = ($this->kernel)($this->factory, 'env', true);

                    $kernel = new HttpKernelWithoutBootFailure(
                        new AppRequestHandler($this->dispatcher, $this->factory, true),
                        $this->factory,
                        true
                    );

                    expect($test)->toEqual($kernel);

                });

            });

        });

        context('when an exception is thrown while building the AppRequestHandler', function () {

            beforeEach(function () {

                $this->exception = mock(Throwable::class)->get();

                $this->dfactory->__invoke->with($this->handler, $this->middleware)->throws($this->exception);

            });

            context('when the given debug mode is false', function () {

                it('should return a HttpKernelWithBootFailure wrapped around the exception with debug mode to false', function () {

                    $test = ($this->kernel)($this->factory, 'env', false);

                    $kernel = new HttpKernelWithBootFailure($this->exception, $this->factory, false);

                    expect($test)->toEqual($kernel);

                });

            });

            context('when the given debug mode is true', function () {

                it('should return a HttpKernelWithBootFailure wrapped around the exception with debug mode to true', function () {

                    $test = ($this->kernel)($this->factory, 'env', true);

                    $kernel = new HttpKernelWithBootFailure($this->exception, $this->factory, true);

                    expect($test)->toEqual($kernel);

                });

            });

        });

    });

});
