<?php
namespace Lorenum\Ionian\Errors\HTTPExceptions;

/**
 * 401 Unauthorized
 * Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not yet been provided.
 */
Class HTTPException_401 extends HTTPException{
    public function __construct($message = 'Unauthorized resource or insufficient permission level.') {
        parent::__construct("Unauthorized", 401, $message);
    }
}