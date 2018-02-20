<?php

use Interop\Container\ServiceProviderInterface;

use Ellipse\Container;
use Ellipse\Http\HttpServiceProvider;
use Ellipse\Http\Handlers\DefaultRequestHandler;

describe('HttpServiceProvider', function () {

    beforeEach(function () {

        $this->provider = new HttpServiceProvider;

    });

    it('should implement ServiceProviderInterface', function () {

        expect($this->provider)->toBeAnInstanceOf(ServiceProviderInterface::class);

    });

    context('when consumed by a container', function () {

        beforeEach(function () {

            $this->container = new Container([$this->provider]);

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
