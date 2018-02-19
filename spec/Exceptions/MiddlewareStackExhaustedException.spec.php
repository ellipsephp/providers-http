<?php

use Ellipse\Http\Exceptions\MiddlewareStackExhaustedException;
use Ellipse\Http\Exceptions\HttpExceptionInterface;

describe('MiddlewareStackExhaustedException', function () {

    it('should implements HttpExceptionInterface', function () {

        $test = new MiddlewareStackExhaustedException;

        expect($test)->toBeAnInstanceOf(HttpExceptionInterface::class);

    });

});
