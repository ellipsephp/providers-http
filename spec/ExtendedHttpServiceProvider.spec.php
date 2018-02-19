<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Container;
use Ellipse\Http\ExtendedHttpServiceProvider;
use Ellipse\Http\HttpKernelFactory;
use Ellipse\Http\DefaultHttpKernelFactory;
use Ellipse\Http\Handlers\DefaultRequestHandler;
use Ellipse\Providers\ExtendedServiceProvider;

describe('ExtendedHttpServiceProvider', function () {

    beforeEach(function () {

        $this->provider = new ExtendedHttpServiceProvider;

    });

    it('should implement ExtendedServiceProvider', function () {

        expect($this->provider)->toBeAnInstanceOf(ExtendedServiceProvider::class);

    });

    context('when consumed by a container', function () {

        beforeEach(function () {

            $this->container = new Container([$this->provider]);

        });

        it('should provide an instance of DefaultHttpKernelFactory for the HttpKernelFactory::class alias', function () {

            $test = $this->container->get(HttpKernelFactory::class);

            expect($test)->toBeAnInstanceOf(DefaultHttpKernelFactory::class);

        });

        it('should provide an empty array for the ellipse.http.middleware alias', function () {

            $test = $this->container->get('ellipse.http.middleware');

            expect($test)->toEqual([]);

        });

        it('should provide an instance of DefaultRequestHandler for the ellipse.http.handler alias', function () {

            $test = $this->container->get('ellipse.http.handler');

            expect($test)->toBeAnInstanceOf(DefaultRequestHandler::class);

        });

        context('when an extension is given for ellipse.http.middleware alias', function () {

            it('should return the value returned by the extension', function () {

                $provider = new ExtendedHttpServiceProvider([
                    'ellipse.http.middleware' => function () { return ['middleware']; },
                ]);

                $container = new Container([$provider]);

                $test = $container->get('ellipse.http.middleware');

                expect($test)->toEqual(['middleware']);

            });

        });

        context('when an extension is given for ellipse.http.handler alias', function () {

            it('should return the value returned by the extension', function () {

                $handler = mock(RequestHandlerInterface::class)->get();

                $provider = new ExtendedHttpServiceProvider([
                    'ellipse.http.handler' => function () use ($handler) { return $handler; },
                ]);

                $container = new Container([$provider]);

                $test = $container->get('ellipse.http.handler');

                expect($test)->toBe($handler);

            });

        });

    });

});
