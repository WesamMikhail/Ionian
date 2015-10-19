<?php
namespace Lorenum\Ionian\Errors\Exceptions;

/**
 * 500 Internal Server Error
 * A generic error message, given when an unexpected condition was encountered and no more specific message is suitable.
 */
Class HTTPException_500 extends HTTPException{
    public function __construct($message = 'Internal server error for unknown reasons.') {
        parent::__construct("Internal Server Error", 500, $message);
    }
}