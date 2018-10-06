<?php

namespace Qh\Twig;

use Twig\Environment;
use Illuminate\Support\ServiceProvider;

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
        $this->registerTwigExtensions();
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
        $this->app->bind('twig.loader', function ($app) {
            return new TwigLoader($app['files'], $app['view.finder'], $app['config']['twig.extension']);
        });
        $this->app->alias('twig.loader', TwigLoader::class);
    }

    /**
     * Register twig engine.
     */
    public function registerTwigEngine()
    {
        $this->app->bind('twig.engine', function ($app) {
            return new TwigEngine($app['twig.environment']);
        });
        $this->app->alias('twig.engine', TwigEngine::class);
    }

    /**
     * Register twig extensions.
     */
    protected function registerTwigExtensions()
    {
        $this->app->instance('twig.extensions', $this->app['config']['twig.extensions']);
    }

    /**
     * Register twig environment.
     */
    protected function registerTwigEnvironment()
    {
        $this->app->bind('twig.environment', function ($app) {
            $env = new Environment($app['twig.loader'], [
                'cache' => $app['config']['twig.compiled'],
                'debug' => $app['config']['app.debug'],
            ]);

            // Load extensions...
            foreach ($app['twig.extensions'] as $extension) {
                $env->addExtension($app->make($extension));
            }

            // Add gloabls...
            $env->addGlobal('app', $app);

            return $env;
        });

        $this->app->alias('twig.environment', \Qh\Twig\TwigEnvironment::class);
        $this->app->alias('twig.environment', \Twig\Environment::class);
        $this->app->alias('twig.environment', \Twig_Environment::class);
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/twig.php' => config_path('twig.php'),
        ], 'twig-config');

        $this->registerViewExtension();
        $this->registerCommands();
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
     * Register commands.
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Qh\Twig\Console\ViewTwigClearCommand::class,
            ]);
        }
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
            'twig.extensions',
        ];
    }
}
