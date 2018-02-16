<?php declare(strict_types=1);

namespace Ellipse\Http;

use Ellipse\Providers\ExtendedServiceProvider;

class ExtendedHttpServiceProvider extends ExtendedServiceProvider
{
    public function __construct(array $extensions = [])
    {
        parent::__construct(new HttpServiceProvider, $extensions);
    }
}
