<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Dispatcher;
use Ellipse\DispatcherFactoryInterface;
use Ellipse\Http\AppRequestHandler;
use Ellipse\Http\HttpKernelFactory;
use Ellipse\Http\DefaultHttpKernelFactory;
use Ellipse\Http\HttpKernelWithBootFailure;
use Ellipse\Http\HttpKernelWithoutBootFailure;

describe('DefaultHttpKernelFactory', function () {

    beforeEach(function () {

        $this->container = mock(ContainerInterface::class);

        $this->factory = new DefaultHttpKernelFactory($this->container->get());

    });

    it('should extend HttpKernelFactory', function () {

        expect($this->factory)->toBeAnInstanceOf(HttpKernelFactory::class);

    });

    describe('->__invoke()', function () {

        context('when the container does not throw an exception', function () {

            beforeEach(function () {

                $factory = mock(DispatcherFactoryInterface::class);
                $middleware = [mock(MiddlewareInterface::class)->get()];
                $handler = mock(RequestHandlerInterface::class)->get();
                $this->dispatcher = mock(Dispatcher::class)->get();

                $this->container->get->with(DispatcherFactoryInterface::class)->returns($factory);
                $this->container->get->with('ellipse.http.middleware')->returns($middleware);
                $this->container->get->with('ellipse.http.handler')->returns($handler);
                $factory->__invoke->with($handler, $middleware)->returns($this->dispatcher);

            });

            context('when the given debug mode is false', function () {

                it('should return a HttpKernelWithoutBootFailure wrapped around the produced AppRequestHandler with debug mode to false', function () {

                    $test = ($this->factory)('env', false);

                    $kernel = new HttpKernelWithoutBootFailure(
                        new AppRequestHandler($this->dispatcher, false), false
                    );

                    expect($test)->toEqual($kernel);

                });

            });

            context('when the given debug mode is true', function () {

                it('should return a HttpKernelWithoutBootFailure wrapped around the produced AppRequestHandler with debug mode to true', function () {

                    $test = ($this->factory)('env', true);

                    $kernel = new HttpKernelWithoutBootFailure(
                        new AppRequestHandler($this->dispatcher, true), true
                    );

                    expect($test)->toEqual($kernel);

                });

            });

        });

        context('when an exception is thrown while building the AppRequestHandler', function () {

            beforeEach(function () {

                $factory = mock(DispatcherFactoryInterface::class);
                $middleware = [mock(MiddlewareInterface::class)->get()];
                $handler = mock(RequestHandlerInterface::class)->get();
                $this->exception = mock(Throwable::class)->get();

                $this->container->get->with(DispatcherFactoryInterface::class)->returns($factory);
                $this->container->get->with('ellipse.http.middleware')->returns($middleware);
                $this->container->get->with('ellipse.http.handler')->returns($handler);
                $factory->__invoke->with($handler, $middleware)->throws($this->exception);

            });

            context('when the given debug mode is false', function () {

                it('should return a HttpKernelWithBootFailure wrapped around the exception with debug mode to false', function () {

                    $test = ($this->factory)('env', false);

                    $kernel = new HttpKernelWithBootFailure($this->exception, false);

                    expect($test)->toEqual($kernel);

                });

            });

            context('when the given debug mode is true', function () {

                it('should return a HttpKernelWithBootFailure wrapped around the exception with debug mode to true', function () {

                    $test = ($this->factory)('env', true);

                    $kernel = new HttpKernelWithBootFailure($this->exception, true);

                    expect($test)->toEqual($kernel);

                });

            });

        });

    });

});
