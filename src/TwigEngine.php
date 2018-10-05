<?php

namespace Qh\Twig;

use Exception;
use ErrorException;
use Illuminate\Contracts\View\Engine;

class TwigEngine implements Engine
{
    /**
     * The twig loader instance.
     *
     * @var \Qh\Twig\TwigEnvironment
     */
    protected $environment;

    /**
     * A stack of the last compiled templates.
     *
     * @var array
     */
    protected $lastCompiled = [];

    /**
     * Create a new Blade view engine instance.
     *
     * @param  \Qh\Twig\TwigEnvironment $environment
     * @return void
     */
    public function __construct(TwigEnvironment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param  string $path
     * @param  array $data
     * @return string
     * @throws Exception
     */
    public function get($path, array $data = [])
    {
        $this->lastCompiled[] = $path;

        $results = '';

        try {
            $results = $this->getEnvironment()->render($path, $data);
        } catch (Exception $e) {
            $this->handleViewException($e);
        }

        array_pop($this->lastCompiled);

        return $results;
    }

    /**
     * Handle a view exception.
     *
     * @param  \Exception  $e
     * @return void
     *
     * @throws \Exception
     */
    protected function handleViewException(Exception $e)
    {
         throw new ErrorException($this->getMessage($e), 0, 1, $e->getFile(), $e->getLine(), $e);
    }

    /**
     * Get the exception message for an exception.
     *
     * @param  \Exception  $e
     * @return string
     */
    protected function getMessage(Exception $e)
    {
        return $e->getMessage().' (View: '.realpath(last($this->lastCompiled)).')';
    }

    /**
     * Get the compiler implementation.
     *
     * @return TwigEnvironment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
