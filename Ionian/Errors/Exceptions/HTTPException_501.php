<?php
namespace Ionian\Errors\Exceptions;

/**
 * 501 Not Implemented
 * The server either does not recognize the request method, or it lacks the ability to fulfill the request. Usually this implies future availability (e.g., a new feature of a web-service API).
 */
Class HTTPException_501 extends HTTPException{
    public function __construct($message = 'Server route request method is not supported.') {
        parent::__construct("Not Implemented", 501, $message);
    }
}