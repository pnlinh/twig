<?php

namespace Qh\Twig;

use Illuminate\Support\ServiceProvider;
use Twig\Environment;

class TwigServiceProvider extends ServiceProvider
{
    /**
     * Built-in Extensions.
     */
    protected $extensions = [
        Extensions\UrlExtension::class,
        Extensions\CollectionExtension::class,
        Extensions\StringExtension::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadConfiguration();
        $this->registerTwigLoader();
        $this->registerTwigEnvironment();
        $this->registerTwigEngine();
    }

    /**
     * Load configuration.
     */
    protected function loadConfiguration()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/twig.php', 'twig');
    }

    /**
     * Register twig loader.
     */
    protected function registerTwigLoader()
    {
        $this->app->singleton('twig.loader', function ($app) {
            return new TwigLoader($app['files'], $app['view.finder'], $app['config']['twig.extension']);
        });
    }

    /**
     * Register twig engine.
     */
    public function registerTwigEngine()
    {
        $this->app->singleton('twig.engine', function ($app) {
            return new TwigEngine($app['twig.environment']);
        });
    }

    /**
     * Register twig environment.
     */
    protected function registerTwigEnvironment()
    {
        $this->app->singleton('twig.environment', function ($app) {
            $env = new Environment($app['twig.loader'], [
                'cache' => $app['config']['twig.compiled'],
                'debug' => $app['config']['app.debug'],
            ]);

            foreach ($this->extensions as $extension) {
                $env->addExtension($app->make($extension));
            }

            // Add gloabls...
            $env->addGlobal('app', $app);

            return $env;
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/twig.php' => config_path('twig.php'),
        ], 'twig-config');

        $this->registerViewExtension();
    }

    /**
     * Register view extension.
     */
    protected function registerViewExtension()
    {
        $this->app['view']->addExtension($this->app['config']['twig.extension'], 'twig', function ($app) {
            return $app['twig.engine'];
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'twig.loader',
            'twig.environment',
            'twig.engine',
        ];
    }

}
