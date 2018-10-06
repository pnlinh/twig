<?php

namespace Qh\Twig\Tests;

use Mockery as m;
use Illuminate\View\Factory;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\View\Engines\EngineResolver;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function tearDown()
    {
        m::close();
    }

    protected function getApplication(array $customConfig = [])
    {
        return tap(new Application, function ($app) {
            /*
             * @var \Illuminate\Foundation\Application $app
             */
            $app->instance('path', __DIR__);

            // Default
            $app['env'] = 'testing';
            $app['path.config'] = __DIR__.'/config';
            $app['path.storage'] = __DIR__.'/storage';

            // Filesystem
            $files = m::mock('Illuminate\Filesystem\Filesystem');
            $app['files'] = $files;

            // View
            $finder = m::mock('Illuminate\View\ViewFinderInterface');
            $finder->shouldReceive('addExtension');

            $app['view'] = new Factory(
                new EngineResolver,
                $finder,
                m::mock('Illuminate\Events\Dispatcher')
            );

            // Config
            $app['config'] = new Repository(include __DIR__.'/../config/twig.php');

            $app->bind('Illuminate\Config\Repository', function () use ($app) {
                return $app['config'];
            });
        });
    }
}
