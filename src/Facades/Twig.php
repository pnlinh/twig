<?php

namespace Qh\Twig\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Qh\Twig\TwigEnvironment
 */
class Twig extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'twig.environment';
    }
}
