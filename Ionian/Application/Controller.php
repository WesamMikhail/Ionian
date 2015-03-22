<?php
namespace Ionian\Application;

abstract class Controller{
    protected $app;

    function __construct(App $app){
        $this->app = $app;
    }
}