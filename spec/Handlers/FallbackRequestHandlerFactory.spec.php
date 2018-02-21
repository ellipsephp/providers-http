<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Http\Factory\ResponseFactoryInterface;

use Ellipse\Http\Handlers\FallbackRequestHandler;
use Ellipse\Http\Handlers\FallbackRequestHandlerFactory;
use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

describe('FallbackRequestHandlerFactory', function () {

    beforeEach(function () {

        $this->factory = mock(ResponseFactoryInterface::class)->get();

    });

    describe('->__invoke()', function () {

        context('when debug option is set to false', function () {

            it('should return a fallback request handler with debug value set to false', function () {

                $factory = new FallbackRequestHandlerFactory($this->factory, false);

                $test = $factory(new MiddlewareStackExhaustedException);

                $handler = new FallbackRequestHandler($this->factory, false);

                expect($test)->toEqual($handler);

            });

        });

        context('when debug option is set to true', function () {

            it('should return a fallback request handler with debug value set to true', function () {

                $factory = new FallbackRequestHandlerFactory($this->factory, (true));

                $test = $factory(new MiddlewareStackExhaustedException);

                $handler = new FallbackRequestHandler($this->factory, true);

                expect($test)->toEqual($handler);

            });

        });

    });

});
