<?php

use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Container;

describe('providers.php', function () {

    beforeEach(function () {

        $this->providers = require __DIR__ . '/../providers.php';

    });

    context('when consumed by a container', function () {

        beforeEach(function () {

            $this->container = new Container($this->providers);

        });

        it('should provide an array for the ellipse.http.middleware alias', function () {

            $test = $this->container->get('ellipse.http.middleware');

            expect($test)->toBeAn('array');

        });

        it('should provide an implementation of RequestHandlerInterface for the ellipse.http.handler alias', function () {

            $test = $this->container->get('ellipse.http.handler');

            expect($test)->toBeAnInstanceOf(RequestHandlerInterface::class);

        });

    });

});
