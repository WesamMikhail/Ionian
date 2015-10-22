<?php
namespace Lorenum\Ionian\Errors\ApplicationExceptions;

use Exception;

class ArgumentException extends Exception{
    public function __construct($message = 'The given function argument does not meet the expected criteria', $code = 500){
        parent::__construct($message, 500);
    }
}