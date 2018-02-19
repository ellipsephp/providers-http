<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Http\Handlers\DefaultRequestHandler;
use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

describe('DefaultRequestHandler', function () {

    beforeEach(function () {

        $this->handler = new DefaultRequestHandler;

    });

    it('should implement RequestHandlerInterface', function () {

        expect($this->handler)->toBeAnInstanceOf(RequestHandlerInterface::class);

    });

    describe('->handle()', function () {

        beforeEach(function () {

            $this->request = mock(ServerRequestInterface::class)->get();

        });

        it('should throw a MiddlewareStackExhaustedException', function () {

            $test = function () { $this->handler->handle($this->request); };

            $exception = new MiddlewareStackExhaustedException;

            expect($test)->toThrow($exception);

        });

    });

});
