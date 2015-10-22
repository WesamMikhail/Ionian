<?php
namespace Lorenum\Ionian\Errors\ApplicationExceptions;

use Exception;

/**
 * Class ArgumentException
 * To be used when a function argument is not of expected value or when a value is not expected type
 *
 * @package Lorenum\Ionian\Errors\ApplicationExceptions
 */
class ArgumentException extends Exception{
    public function __construct($message = 'The given function argument does not meet the expected criteria', $code = 500){
        parent::__construct($message, 500);
    }
}