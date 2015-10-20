<?php
namespace Lorenum\Ionian\Errors\HTTPExceptions;

/**
 * 400 Bad Request
 * The server cannot or will not process the request due to something that is perceived to be a client error
 * (e.g., malformed request syntax, invalid request message framing, or deceptive request routing)
 */
Class HTTPException_400 extends HTTPException{
    public function __construct($message = 'Unexpected route, invalid value or missing parameter in the request.') {
        parent::__construct("Bad Request", 400, $message);
    }
}