<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Zend\Diactoros\Response;

use Ellipse\Http\Handlers\AppRequestHandler;
use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;

describe('AppRequestHandler', function () {

    beforeEach(function () {

        $this->delegate = mock(RequestHandlerInterface::class);
        $this->prototype = new Response;

    });

    it('should implement RequestHandlerInterface', function () {

        $test = new AppRequestHandler($this->delegate->get(), $this->prototype, false);

        expect($test)->toBeAnInstanceOf(RequestHandlerInterface::class);

    });

    describe('->handle()', function () {

        beforeEach(function () {

            $this->request = mock(ServerRequestInterface::class);

        });

        context('when debug option is set to false', function () {

            beforeEach(function () {

                $this->handler = new AppRequestHandler($this->delegate->get(), $this->prototype, false);

            });

            context('when the request handler does not throw an exception', function () {

                it('should proxy the request handler', function () {

                    $response = mock(ResponseInterface::class)->get();

                    $this->delegate->handle->with($this->request->get())->returns($response);

                    $test = $this->handler->handle($this->request->get());

                    expect($test)->toBe($response);

                });

            });

            context('when the request handler throws an exception', function () {

                context('when the exception is not a MiddlewareStackExhaustedException', function () {

                    it('should propagate the exception', function () {

                        $exception = mock(Throwable::class)->get();

                        $this->delegate->handle->with($this->request->get())->throws($exception);

                        $test = function () {

                            $this->handler->handle($this->request->get());

                        };

                        expect($test)->toThrow($exception);

                    });

                });

                context('when the exception is a MiddlewareStackExhaustedException', function () {

                    beforeEach(function () {

                        $exception = new MiddlewareStackExhaustedException;

                        $this->delegate->handle->with($this->request->get())->throws($exception);

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

            });

        });

        context('when debug option is set to true', function () {

            beforeEach(function () {

                $this->handler = new AppRequestHandler($this->delegate->get(), $this->prototype, true);

            });

            context('when the request handler does not throw an exception', function () {

                it('should proxy the request handler', function () {

                    $response = mock(ResponseInterface::class)->get();

                    $this->delegate->handle->with($this->request->get())->returns($response);

                    $test = $this->handler->handle($this->request->get());

                    expect($test)->toBe($response);

                });

            });

            context('when the request handler throws an exception', function () {

                context('when the exception is not a MiddlewareStackExhaustedException', function () {

                    it('should propagate the exception', function () {

                        $exception = mock(Throwable::class)->get();

                        $this->delegate->handle->with($this->request->get())->throws($exception);

                        $test = function () {

                            $this->handler->handle($this->request->get());

                        };

                        expect($test)->toThrow($exception);

                    });

                });

                context('when the exception is a MiddlewareStackExhaustedException', function () {

                    beforeEach(function () {

                        $exception = new MiddlewareStackExhaustedException;

                        $this->delegate->handle->with($this->request->get())->throws($exception);

                    });

                    context('when the request is an ajax request', function () {

                        it('should return a not found json response', function () {

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

                            it('should return a not found json response', function () {

                                $this->request->getHeaderLine->with('Accept', '*/*')->returns('application/json');

                                $test = $this->handler->handle($this->request->get());

                                expect($test->getStatusCode())->toEqual(404);
                                expect($test->getHeaderLine('Content-type'))->toContain('application/json');
                                expect(json_decode((string) $test->getBody(), true))->toContain(MiddlewareStackExhaustedException::class);

                            });

                        });

                        context('when the request do not prefer json contents', function () {

                            it('should return a not found html response', function () {

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

    });

});
