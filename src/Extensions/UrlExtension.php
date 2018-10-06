<?php

namespace Qh\Twig\Extensions;

use Twig\TwigFilter;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Twig\Extension\AbstractExtension;

class UrlExtension extends AbstractExtension
{
    /**
     * @var \Illuminate\Routing\UrlGenerator
     */
    protected $url;

    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Create a new url extension.
     *
     * @param \Illuminate\Routing\UrlGenerator
     * @param \Illuminate\Routing\Router
     */
    public function __construct(UrlGenerator $url, Router $router)
    {
        $this->url = $url;
        $this->router = $router;
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('asset', [$this->url, 'asset'], ['is_safe' => ['html']]),
            new TwigFilter('action', [$this->url, 'action'], ['is_safe' => ['html']]),
            new TwigFilter('url', [$this->url, 'to'], ['is_safe' => ['html']]),
            new TwigFilter('route', [$this->url, 'route'], ['is_safe' => ['html']]),
            new TwigFilter('route_has', [$this->router, 'has'], ['is_safe' => ['html']]),
            new TwigFilter('secure_url', [$this->url, 'secure'], ['is_safe' => ['html']]),
            new TwigFilter('secure_asset', [$this->url, 'secureAsset'], ['is_safe' => ['html']]),
        ];
    }
}
