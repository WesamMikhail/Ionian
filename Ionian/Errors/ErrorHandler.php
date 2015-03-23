<?php
namespace Ionian\Errors;

abstract class ErrorHandler implements ErrorHandlerInterface{
    protected $protocol;
    function __construct(){
        $this->protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1');
    }
}