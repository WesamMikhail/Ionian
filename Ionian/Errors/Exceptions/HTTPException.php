<?php
namespace Ionian\Errors\Exceptions;

/**
 * Class HTTPException
 * Base Exception class for Ionian framework
 *
 * @package Ionian\Errors\Exceptions
 */
class HTTPException extends \Exception{
    protected $status;

    public function __construct($status, $code, $message = ''){
        $this->status = $status;
        parent::__construct($message, $code);
    }

    public function getStatus() {
        return $this->status;
    }
}