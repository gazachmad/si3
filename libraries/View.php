<?php

namespace Lib;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;

class View extends Factory
{
    public function __construct()
    {
        parent::__construct(new EngineResolver, new FileViewFinder(new Filesystem, [VIEWPATH]), new Dispatcher(new Container));

        $this->_initialize();
    }

    private function _initialize()
    {
        parent::addExtension('blade.php', 'blade', function () {
            return new CompilerEngine(new BladeCompiler(new Filesystem, FCPATH . 'bootstrap/Cache'));
        });
    }

    public function render($view, $data = [], $mergeData = [])
    {
        echo parent::make($view, $data, $mergeData)->render();
    }
}
