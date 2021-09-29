<?php

namespace App\Core;

use CI_Controller as BaseCore;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Request;
use Lib\DB;
use Lib\Response;
use Lib\Validation;
use Lib\View;
use Symfony\Component\HttpFoundation\Session\Session;

class Core extends BaseCore
{
    protected $db;
    protected $http;
    protected $request;
    protected $response;
    protected $session;
    protected $validation;
    protected $view;

    protected $helpers = ['url'];

    public function __construct()
    {
        parent::__construct();

        $this->_initialize();

        $this->load->helper($this->helpers);
    }

    private function _initialize()
    {
        $this->db         = new DB;
        
        $this->http       = new Factory;

        $request          = new Request;
        $this->request    = $request->capture();

        $this->response   = new Response;

        $session          = new Session;
        $this->session    = $session->start();

        $this->validation = new Validation;

        $this->view       = new View;
    }
}
