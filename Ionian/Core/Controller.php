<?php
namespace Ionian\Core;

use Ionian\Errors\ErrorHandlerInterface;

abstract class Controller{
    protected $errorHandler;

    function __construct(ErrorHandlerInterface $errorhandler){
        $this->errorHandler = $errorhandler;
    }
}