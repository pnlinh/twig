<?php

namespace Qh\Twig;

use Illuminate\Support\ServiceProvider;
use Twig\Environment;

class TwigServiceProvider extends ServiceProvider
{
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
     * Register twig environment.
     */
    protected function registerTwigEnvironment()
    {
        $this->app->singleton('twig.environment', function ($app) {
            return new Environment($app['twig.loader'], [
                'cache' => $app['config']['twig.compiled'],
                'debug' => $app['config']['app.default'],
            ]);
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
        ];
    }

}
