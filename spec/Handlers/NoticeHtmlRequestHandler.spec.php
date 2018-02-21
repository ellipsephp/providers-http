<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Http\Factory\Diactoros\ResponseFactory;

use Ellipse\Http\Handlers\NoticeHtmlRequestHandler;

describe('NoticeHtmlRequestHandler', function () {

    beforeEach(function () {

        $this->handler = new NoticeHtmlRequestHandler(new ResponseFactory);

    });

    it('should implement RequestHandlerInterface', function () {

        expect($this->handler)->toBeAnInstanceOf(RequestHandlerInterface::class);

    });

    describe('->handle()', function () {

        beforeEach(function () {

            $this->request = mock(ServerRequestInterface::class)->get();

        });

        it('should return a notice html response', function () {

            $test = $this->handler->handle($this->request);

            expect($test->getStatusCode())->toEqual(404);
            expect($test->getHeaderLine('Content-type'))->toContain('text/html');
            expect((string) $test->getBody())->toContain('Welcome to ellipse!');

        });

    });

});
