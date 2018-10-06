<?php

namespace Qh\Twig\Extensions;

use Twig\TwigFunction;
use Illuminate\Support\Facades\Auth;
use Twig\Extension\GlobalsInterface;
use Twig\Extension\AbstractExtension;

class AuthExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return [
            'auth' => $this->guard(),
            'auth_user' => $this->guard()->user(),
            'auth_check' => $this->guard()->check(),
            'auth_guest' => $this->guard()->guest(),
        ];
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('auth', [$this, 'guard']),
        ];
    }

    /**
     * @param null $guard
     * @return \Illuminate\Contracts\Auth\Guard
     */
    protected function guard($guard = null)
    {
        return Auth::guard($guard);
    }
}
