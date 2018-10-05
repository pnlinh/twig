<?php

namespace Qh\Twig;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\ViewFinderInterface;
use InvalidArgumentException;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Source;

class TwigLoader implements LoaderInterface
{
    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var ViewFinderInterface
     */
    protected $finder;

    /**
     * @var string
     */
    protected $extension = 'html';

    /**
     * @var array Template lookup cache.
     */
    protected $cache = [];

    /**
     * TwigLoader constructor.
     *
     * @param  Filesystem  $files
     * @param  ViewFinderInterface  $finder
     * @param  string  $extension
     */
    public function __construct(Filesystem $files, ViewFinderInterface $finder, $extension = 'html')
    {
        $this->files = $files;
        $this->finder = $finder;
        $this->extension = $extension;
    }

    /**
     * Returns the source context for a given template logical name.
     *
     * @param  string $name The template logical name
     * @return \Twig\Source
     * @throws \Twig\Error\LoaderError When $name is not found
     */
    public function getSourceContext($name)
    {
        $path = $this->findTemplate($name);

        try {
            return new Source($this->files->get($path), $name, $path);
        } catch (FileNotFoundException $e) {
            throw new LoaderError("View [{$name}] not found (Path: {$path}).");
        }
    }

    /**
     * Return path to template without the need for the extension.
     *
     * @param  string  $name
     * @return string Path to template
     * @throws LoaderError
     */
    public function findTemplate($name)
    {
        if ($this->files->exists($name)) {
            return $name;
        }

        $name = $this->normalizeName($name);

        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        try {
            $this->cache[$name] = $this->finder->find($name);
        } catch (InvalidArgumentException $ex) {
            throw new LoaderError($ex->getMessage());
        }

        return $this->cache[$name];
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws LoaderError When $name is not found
     */
    public function getCacheKey($name)
    {
        return $this->findTemplate($name);
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string $name The template name
     * @param int $time Timestamp of the last modification time of the
     *                     cached template
     *
     * @return bool true if the template is fresh, false otherwise
     *
     * @throws LoaderError When $name is not found
     */
    public function isFresh($name, $time)
    {
        return $this->files->lastModified($this->findTemplate($name)) <= $time;
    }

    /**
     * Check if we have the source code of a template, given its name.
     *
     * @param string $name The name of the template to check if we can load
     *
     * @return bool If the template source code is handled by this loader or not
     */
    public function exists($name)
    {
        try {
            $this->findTemplate($name);
        } catch (LoaderError $exception) {
            return false;
        }

        return true;
    }


    /**
     * Normalize the Twig template name to a name the ViewFinder can use
     *
     * @param  string  $name
     * @return string The parsed name
     */
    protected function normalizeName($name)
    {
        if ($this->files->extension($name) === $this->extension) {
            $name = substr($name, 0, - (strlen($this->extension) + 1));
        }

        return $name;
    }
}
