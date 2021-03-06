<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Session\Session;

require_once realpath(__DIR__ . '/../vendor') . '/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/
$dotEnv = Dotenv::createImmutable(realpath(__DIR__ . '/..') . '/');
$dotEnv->load();

$session = new Session;
$session->start();

require_once realpath(__DIR__ . '/../bootstrap') . '/app.php';
