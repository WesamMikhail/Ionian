<?php
namespace Lorenum\Ionian\Errors\ApplicationExceptions;

use Exception;

/**
 * Class InstanceException
 * To be used when the instance is corrupt or the process is unable to create an instance of a given class
 *
 * @package Lorenum\Ionian\Errors\ApplicationExceptions
 */
class InstanceException extends Exception{
    public function __construct($message = 'Unable to create an instance of the requested class', $code = 500){
        parent::__construct($message, 500);
    }
}