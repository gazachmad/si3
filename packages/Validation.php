<?php

namespace Packages;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class Validation extends Factory
{
    public function __construct()
    {
        parent::__construct(new Translator(new FileLoader(new Filesystem, realpath(__DIR__ . '/../app/Language') . '/'), 'en'));
    }
}
