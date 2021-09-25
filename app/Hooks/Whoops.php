<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class Whoops
{
    public function bootWhoops()
    {
        $whoops = new Run;
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();
    }
}
