<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Http\Factory\Diactoros\ResponseFactory;

use Ellipse\Http\Handlers\NotFoundJsonRequestHandler;

describe('NotFoundJsonRequestHandler', function () {

    beforeEach(function () {

        $this->handler = new NotFoundJsonRequestHandler(new ResponseFactory);

    });

    it('should implement RequestHandlerInterface', function () {

        expect($this->handler)->toBeAnInstanceOf(RequestHandlerInterface::class);

    });

    describe('->handle()', function () {

        beforeEach(function () {

            $this->request = mock(ServerRequestInterface::class)->get();

        });

        it('should return a not found json response', function () {

            $test = $this->handler->handle($this->request);

            expect($test->getStatusCode())->toEqual(404);
            expect($test->getHeaderLine('Content-type'))->toContain('application/json');
            expect(json_decode($test->getBody(), true))->toContain('Not found');

        });

    });

});
