<?php
namespace Ionian\Core;

use Ionian\Errors\ErrorHandlerInterface;

abstract class Controller{
    protected $appName;

    function __construct($appName, ErrorHandlerInterface $errorhandler){
        $this->appName = $appName;
        $this->errorHandler = $errorhandler;
    }
}