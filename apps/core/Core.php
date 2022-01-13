<?php

namespace App\core;

use CI_Controller as BaseCore;
use Packages\DB;
use Packages\Http;
use Packages\Request;
use Packages\Response;
use Packages\Session;
use Packages\Validation;
use Packages\View;

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

        $this->http       = new Http;

        $this->request    = Request::capture();

        $this->response   = new Response;

        $this->session    = new Session;

        $this->validation = new Validation;

        $this->view       = new View;
    }
}
