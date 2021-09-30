<?php

namespace Packages;

use Illuminate\Http\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Session\Session;

class Request extends HttpRequest
{
    public function __construct()
    {
        parent::__construct();

        $this->_initialize();
    }

    private function _initialize()
    {
        $this->setLaravelSession(new Session);
    }
}
