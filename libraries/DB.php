<?php

namespace Lib;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;

class DB extends Manager
{
    private static $config;

    public function __construct()
    {
        parent::__construct();

        $this->_initialize();
    }

    private function _initialize()
    {
        static::$config = [
            'driver'   => $_SERVER['DB_CONNECTION'],
            'host'     => $_SERVER['DB_HOST'],
            'port'     => $_SERVER['DB_PORT'],
            'database' => $_SERVER['DB_DATABASE'],
            'username' => $_SERVER['DB_USERNAME'],
            'password' => $_SERVER['DB_PASSWORD'],
        ];

        $this->addConnection(static::$config);
        $this->setEventDispatcher(new Dispatcher(new Container));
        $this->setAsGlobal();
        $this->bootEloquent();
    }

    public function __call($method, $parameters)
    {
        return static::connection()->$method(...$parameters);
    }
}
