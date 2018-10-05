<?php

namespace Qh\Twig\Extensions;

use Illuminate\Contracts\Auth\Access\Gate;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AuthorizationExtension extends AbstractExtension
{
    /**
     * @var Gate
     */
    protected $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('can', [$this->gate, 'allows']),
            new TwigFilter('allow', [$this->gate, 'allows']),
            new TwigFilter('allows', [$this->gate, 'allows']),
            new TwigFilter('cannot', [$this->gate, 'allows']),
            new TwigFilter('cant', [$this->gate, 'denies']),
            new TwigFilter('deny', [$this->gate, 'denies']),
            new TwigFilter('denies', [$this->gate, 'denies']),
        ];
    }
}
