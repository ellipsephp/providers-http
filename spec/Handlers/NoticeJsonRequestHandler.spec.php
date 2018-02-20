<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Zend\Diactoros\Response;

use Ellipse\Http\Handlers\NoticeJsonRequestHandler;
use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

describe('NoticeJsonRequestHandler', function () {

    beforeEach(function () {

        $this->handler = new NoticeJsonRequestHandler(new Response);

    });

    it('should implement RequestHandlerInterface', function () {

        expect($this->handler)->toBeAnInstanceOf(RequestHandlerInterface::class);

    });

    describe('->handle()', function () {

        beforeEach(function () {

            $this->request = mock(ServerRequestInterface::class)->get();

        });

        it('should return a notice json response', function () {

            $test = $this->handler->handle($this->request);

            expect($test->getStatusCode())->toEqual(404);
            expect($test->getHeaderLine('Content-type'))->toContain('application/json');
            expect(json_decode($test->getBody(), true))->toContain(MiddlewareStackExhaustedException::class);

        });

    });

});
