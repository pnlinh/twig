<?php

namespace Qh\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TranslationExtension extends AbstractExtension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('trans', 'trans', ['pre_escape' => 'html', 'is_safe' => ['html']]),
            new TwigFilter('trans_choice', 'trans_choice', ['pre_escape' => 'html', 'is_safe' => ['html']]),
            new TwigFilter('lang', '__', ['pre_escape' => 'html', 'is_safe' => ['html']]),
        ];
    }
}
