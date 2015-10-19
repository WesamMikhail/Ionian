<?php
namespace Lorenum\Ionian\Errors\Exceptions;

/**
 * 408 Request Timeout
 * The server timed out waiting for the request.
 * According to HTTP specifications: "The client did not produce a request within the time that the server was prepared
 * to wait. The client MAY repeat the request without modifications at any later time."
 */
Class HTTPException_408 extends HTTPException{
    public function __construct($message = 'The client took too long to respond.') {
        parent::__construct("Request Timeout", 408, $message);
    }
}