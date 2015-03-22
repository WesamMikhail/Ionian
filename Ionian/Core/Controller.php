<?php
namespace Ionian\Core;

use Ionian\App\App;

abstract class Controller{
    protected $app;

    function __construct(App $app){
        $this->app = $app;
    }
}