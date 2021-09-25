<?php

namespace App\Core;

use CI_Controller as BaseCore;
use Illuminate\Http\Request;
use Lib\DB;
use Lib\Response;
use Lib\View;
use Symfony\Component\HttpFoundation\Session\Session;

class Core extends BaseCore
{
    protected static $db;
    protected static $request;
    protected static $response;
    protected static $session;
    protected static $view;

    protected static $helpers = ['url'];

    public function __construct()
    {
        parent::__construct();

        $this->_initialize();

        $this->load->helper(static::$helpers);
    }

    private function _initialize()
    {
        static::$db = new DB;

        $request = new Request;
        static::$request = $request->capture();

        static::$response = new Response;

        $session = new Session;
        static::$session = $session->start();

        static::$view = new View;
    }
}
