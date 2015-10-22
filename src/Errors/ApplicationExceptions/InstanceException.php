<?php
namespace Lorenum\Ionian\Errors\ApplicationExceptions;

use Exception;

class InstanceException extends Exception{
    public function __construct($message = 'Unable to create an instance of the requested class', $code = 500){
        parent::__construct($message, 500);
    }
}