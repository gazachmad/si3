<?php

namespace App\Core;

class Controller extends Core
{
    protected $routeMiddleware = [
        'auth' => \App\Middleware\Authenticate::class,
    ];

    public function __construct(){
        parent::__construct();

        $this->_runMiddleware();
    }

    protected function middleware()
    {
        return [];
    }

    protected function _runMiddleware()
    {
        $middlewares = $this->middleware();
        foreach ($middlewares as $middleware) {
            $middlewareArray = explode('|', str_replace(' ', '', $middleware));
            $middlewareName = $middlewareArray[0];

            $runMiddleware = TRUE;

            if (isset($middlewareArray[1])) {
                $options = explode(':', $middlewareArray[1]);
                $type = $options[0];
                $methods = explode(',', $options[1]);

                if ($type === 'except') {
                    if (in_array($this->router->method, $methods)) {
                        $runMiddleware = FALSE;
                    }
                } else if ($type === 'only') {
                    if (!in_array($this->router->method, $methods)) {
                        $runMiddleware = FALSE;
                    }
                }
            }

            if ($runMiddleware === TRUE) {
                $className = $this->routeMiddleware[$middlewareName];
                
                if (class_exists($className)) {
                    $object = new $className;
                    $object->handle();
                } else {
                    if (ENVIRONMENT == 'development') {
                        show_error('Unable to load middleware: ' . $className);
                    } else {
                        show_error('Sorry something went wrong.');
                    }
                }
            }
        }
    }
}
