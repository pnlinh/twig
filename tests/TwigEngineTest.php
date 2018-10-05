<?php

namespace Qh\Twig\Tests;

use PHPUnit\Framework\TestCase;
use Qh\Twig\TwigEngine;
use Qh\Twig\TwigEnvironment;
use Qh\Twig\TwigLoader;

class TwigEngineTest extends TestCase
{
    /** @test */
    public function twig_engine_maybe_working_well()
    {
        $this->assertEquals(
            'Hello John Doe!'."\n",
            $this->getEngine()->get(__DIR__ . '/fixtures/hello_world.html', ['name' => 'John Doe'])
        );
    }

    protected function getEngine()
    {
        $filesystem = new \Illuminate\Filesystem\Filesystem();
        $finder = new \Illuminate\View\FileViewFinder($filesystem, [__DIR__]);
        $env    = new TwigEnvironment(new TwigLoader($filesystem, $finder, 'html'));
        
        return new TwigEngine($env);
    }
}
