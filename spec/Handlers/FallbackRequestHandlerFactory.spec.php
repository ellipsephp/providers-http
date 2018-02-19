<?php

use function Eloquent\Phony\Kahlan\mock;

use Negotiation\Negotiator;

use Ellipse\Http\Handlers\FallbackRequestHandler;
use Ellipse\Http\Handlers\FallbackRequestHandlerFactory;
use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

describe('FallbackRequestHandlerFactory', function () {

    beforeEach(function () {

        $this->negotiator = new Negotiator;

    });

    describe('->__invoke()', function () {

        context('when debug option is set to false', function () {

            it('should return a fallback request handler with debug value set to false', function () {

                $factory = new FallbackRequestHandlerFactory(false);

                $test = $factory(new MiddlewareStackExhaustedException);

                $handler = new FallbackRequestHandler($this->negotiator, false);

                expect($test)->toEqual($handler);

            });

        });

        context('when debug option is set to true', function () {

            it('should return a fallback request handler with debug value set to true', function () {

                $factory = new FallbackRequestHandlerFactory(true);

                $test = $factory(new MiddlewareStackExhaustedException);

                $handler = new FallbackRequestHandler($this->negotiator, true);

                expect($test)->toEqual($handler);

            });

        });

    });

});
