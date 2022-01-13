<?php

namespace App\core;

class Controller extends Core
{
    protected $middlewareAlias = [
        'auth'     => \App\middleware\Auth::class,
        'jwt.auth' => \App\middleware\JWTAuth::class,
    ];

    public function __construct(){
        parent::__construct();

        $this->_middlewareRun();
    }

    protected function middleware()
    {
        return [];
    }

    protected function _middlewareRun()
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
                $className = $this->middlewareAlias[$middlewareName];
                
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
