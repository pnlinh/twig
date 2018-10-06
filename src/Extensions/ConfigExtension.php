<?php

namespace Qh\Twig\Extensions;

use Twig\TwigFilter;
use Twig\Extension\GlobalsInterface;
use Twig\Extension\AbstractExtension;
use Illuminate\Contracts\Config\Repository as ConfigContract;

class ConfigExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    public function __construct(ConfigContract $config)
    {
        $this->config = $config;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return [
            'config' => $this->config->all(),
        ];
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('config', [$this->config, 'get']),
            new TwigFilter('config_has', [$this->config, 'has']),
        ];
    }
}
