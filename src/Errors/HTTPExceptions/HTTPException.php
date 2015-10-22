<?php
namespace Lorenum\Ionian\Errors\HTTPExceptions;

use Exception;

/**
 * Class HTTPException
 * Base user facing Exception class for Ionian framework
 *
 * @package Lorenum\Ionian\Errors\HTTPExceptions
 */
class HTTPException extends Exception{
    protected $status;

    public function __construct($status, $code, $message = ''){
        $this->status = $status;
        parent::__construct($message, $code);
    }

    public function getStatus() {
        return $this->status;
    }
}