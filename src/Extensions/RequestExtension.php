<?php

namespace Qh\Twig\Extensions;

use Illuminate\Http\Request;
use Twig\Extension\GlobalsInterface;
use Twig\Extension\AbstractExtension;

class RequestExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {
        return [
            'request' => $this->request,
            'session' => $this->request->session(),
        ];
    }
}
