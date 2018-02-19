<?php

use Ellipse\Container;
use Ellipse\Http\HttpKernelFactory;
use Ellipse\Http\DefaultHttpKernelFactory;
use Ellipse\Http\Handlers\DefaultRequestHandler;

describe('providers.php', function () {

    beforeEach(function () {

        $this->providers = require __DIR__ . '/../providers.php';

    });

    context('when consumed by a container', function () {

        beforeEach(function () {

            $this->container = new Container($this->providers);

        });

        it('should provide an instance of DefaultHttpKernelFactory for the HttpKernelFactory::class alias', function () {

            $test = $this->container->get(HttpKernelFactory::class);

            expect($test)->toBeAnInstanceOf(DefaultHttpKernelFactory::class);

        });

        it('should provide an empty array for the ellipse.http.middleware alias', function () {

            $test = $this->container->get('ellipse.http.middleware');

            expect($test)->toEqual([]);

        });

        it('should provide an instance of DefaultRequestHandler for the ellipse.http.handler alias', function () {

            $test = $this->container->get('ellipse.http.handler');

            expect($test)->toBeAnInstanceOf(DefaultRequestHandler::class);

        });

    });

});
