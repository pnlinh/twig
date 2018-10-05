<?php

namespace Qh\Twig\Tests;

use PHPUnit\Framework\TestCase;
use Qh\Twig\TwigLoader;

class TwigLoaderTest extends TestCase
{
    /**
     * @var TwigLoader
     */
    protected $loader;

    public function setUp()
    {
        parent::setUp();

        $this->loader = $this->getLoader();
    }

    /** @test */
    public function find_simple_template()
    {
        $this->assertEquals(__DIR__ . '/fixtures/hello_world.html', $this->loader->findTemplate('hello_world'));
    }

    /** @test */
    public function find_template_with_directory()
    {
        $this->assertEquals(__DIR__ . '/fixtures/layout/master.html', $this->loader->findTemplate('layout.master'));
    }

    /** @test */
    public function find_template_with_namespace()
    {
        $this->assertEquals(__DIR__ . '/fixtures/namespace/sample.html', $this->loader->findTemplate('namespace::sample'));
    }

    protected function getLoader()
    {
        $filesystem = new \Illuminate\Filesystem\Filesystem();
        $finder     = new \Illuminate\View\FileViewFinder($filesystem, [__DIR__ . '/fixtures']);

        // Register sample extension.
        $finder->addExtension('html');

        // Add namespace.
        $finder->addNamespace('namespace', __DIR__ . '/fixtures/namespace');

        return new TwigLoader($filesystem, $finder);
    }
}
