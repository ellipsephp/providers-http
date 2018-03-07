<?php declare(strict_types=1);

use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Http\HttpServiceProvider;

return [
    new HttpServiceProvider([

        /**
         * The list of Psr-15 middleware used by the http kernel. An empty array
         * of middleware is provided by default.
         */
        'middleware' => function ($container, array $middleware): array {

            return $middleware;

        },

        /**
         * The final Psr-15 middleware used when no middleware returns a
         * response. A default request handler is provided by default.
         */
        'handler' => function ($container, RequestHandlerInterface $handler): RequestHandlerInterface {

            return $handler;

        },

    ]),
];
