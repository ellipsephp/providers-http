<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ResponseInterface;

use Ellipse\Http\Handlers\FallbackRequestHandler;
use Ellipse\Http\Handlers\FallbackRequestHandlerFactory;
use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

describe('FallbackRequestHandlerFactory', function () {

    beforeEach(function () {

        $this->prototype = mock(ResponseInterface::class)->get();

    });

    describe('->__invoke()', function () {

        context('when debug option is set to false', function () {

            it('should return a fallback request handler with debug value set to false', function () {

                $factory = new FallbackRequestHandlerFactory($this->prototype, false);

                $test = $factory(new MiddlewareStackExhaustedException);

                $handler = new FallbackRequestHandler($this->prototype, false);

                expect($test)->toEqual($handler);

            });

        });

        context('when debug option is set to true', function () {

            it('should return a fallback request handler with debug value set to true', function () {

                $factory = new FallbackRequestHandlerFactory($this->prototype, (true));

                $test = $factory(new MiddlewareStackExhaustedException);

                $handler = new FallbackRequestHandler($this->prototype, true);

                expect($test)->toEqual($handler);

            });

        });

    });

});
