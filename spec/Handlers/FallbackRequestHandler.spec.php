<?php declare(strict_types=1);

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Zend\Diactoros\Response;

use Ellipse\Http\Handlers\FallbackRequestHandler;
use Ellipse\Http\Handlers\RequestBasedRequestHandler;
use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

describe('FallbackRequestHandler', function () {

    beforeEach(function () {

        $this->prototype = new Response;

    });

    it('should extend RequestBasedRequestHandler', function () {

        $test = new FallbackRequestHandler($this->prototype, false);

        expect($test)->toBeAnInstanceOf(RequestBasedRequestHandler::class);

    });

    describe('->handle()', function () {

        beforeEach(function () {

            $this->request = mock(ServerRequestInterface::class);

        });

        context('when debug option is set to false', function () {

            beforeEach(function () {

                $this->handler = new FallbackRequestHandler($this->prototype, false);

            });

            context('when the request is an ajax request', function () {

                it('should return a not found json response', function () {

                    $this->request->getServerParams->returns(['HTTP_X_REQUESTED_WITH' => 'xmlhttprequest']);

                    $test = $this->handler->handle($this->request->get());

                    expect($test->getStatusCode())->toEqual(404);
                    expect($test->getHeaderLine('Content-type'))->toContain('application/json');
                    expect(json_decode((string) $test->getBody(), true))->toContain('Not found');

                });

            });

            context('when the request is not an ajax request', function () {

                beforeEach(function () {

                    $this->request->getServerParams->returns([]);

                });

                context('when the request prefers json contents', function () {

                    it('should return a not found json response', function () {

                        $this->request->getHeaderLine->with('Accept', '*/*')->returns('application/json');

                        $test = $this->handler->handle($this->request->get());

                        expect($test->getStatusCode())->toEqual(404);
                        expect($test->getHeaderLine('Content-type'))->toContain('application/json');
                        expect(json_decode((string) $test->getBody(), true))->toContain('Not found');

                    });

                });

                context('when the request do not prefer json contents', function () {

                    it('should return a not found html response', function () {

                        $this->request->getHeaderLine->with('Accept', '*/*')->returns('*/*');

                        $test = $this->handler->handle($this->request->get());

                        expect($test->getStatusCode())->toEqual(404);
                        expect($test->getHeaderLine('Content-type'))->toContain('text/html');
                        expect((string) $test->getBody())->toContain('Not found');

                    });

                });

            });

        });

        context('when debug option is set to true', function () {

            beforeEach(function () {

                $this->handler = new FallbackRequestHandler($this->prototype, true);

            });

            context('when the request is an ajax request', function () {

                it('should return a simple json response', function () {

                    $this->request->getServerParams->returns(['HTTP_X_REQUESTED_WITH' => 'xmlhttprequest']);

                    $test = $this->handler->handle($this->request->get());

                    expect($test->getStatusCode())->toEqual(404);
                    expect($test->getHeaderLine('Content-type'))->toContain('application/json');
                    expect(json_decode((string) $test->getBody(), true))->toContain(MiddlewareStackExhaustedException::class);

                });

            });

            context('when the request is not an ajax request', function () {

                beforeEach(function () {

                    $this->request->getServerParams->returns([]);

                });

                context('when the request prefers json contents', function () {

                    it('should return a simple json response', function () {

                        $this->request->getHeaderLine->with('Accept', '*/*')->returns('application/json');

                        $test = $this->handler->handle($this->request->get());

                        expect($test->getStatusCode())->toEqual(404);
                        expect($test->getHeaderLine('Content-type'))->toContain('application/json');
                        expect(json_decode((string) $test->getBody(), true))->toContain(MiddlewareStackExhaustedException::class);

                    });

                });

                context('when the request do not prefer json contents', function () {

                    it('should return a simple html response', function () {

                        $this->request->getHeaderLine->with('Accept', '*/*')->returns('*/*');

                        $test = $this->handler->handle($this->request->get());

                        expect($test->getStatusCode())->toEqual(404);
                        expect($test->getHeaderLine('Content-type'))->toContain('text/html');
                        expect((string) $test->getBody())->toContain('Welcome to ellipse!');

                    });

                });

            });

        });

    });

});
