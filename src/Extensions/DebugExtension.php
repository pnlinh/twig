<?php

namespace Qh\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DebugExtension extends AbstractExtension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFunctions()
    {
        return [
            new TwigFilter('dump', 'dump'),
            new TwigFilter('dd', 'dd'),
        ];
    }
}
