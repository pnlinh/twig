<?php

namespace Qh\Twig\Extensions;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class MathExtension extends AbstractExtension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('ceil', 'ceil'),
            new TwigFilter('floor', 'floor'),
            new TwigFilter('round', 'round'),
            new TwigFilter('divided_by', [$this, 'devidedBy']),
            new TwigFilter('minus', [$this, 'minus']),
            new TwigFilter('plus', [$this, 'plus']),
            new TwigFilter('times', [$this, 'times']),
            new TwigFilter('mod', [$this, 'mod']),
            new TwigFilter('at_most', [$this, 'atMost']),
            new TwigFilter('at_least', [$this, 'atLeast']),
        ];
    }

    protected function devidedBy($a, $b)
    {
        return $a / $b;
    }

    protected function minus($a, $b)
    {
        return $a - $b;
    }

    protected function plus($a, $b)
    {
        return $a + $b;
    }

    protected function times($a, $b)
    {
        return $a * $b;
    }

    protected function mod($a, $b)
    {
        return $a % $b;
    }

    protected function atMost($a, $b = 0)
    {
        if ($b > 0 && $a > $b) {
            return $b;
        }

        return $a;
    }

    protected function atLeast($a, $b = 0)
    {
        if ($a < $b) {
            return $b;
        }

        return $a;
    }
}
