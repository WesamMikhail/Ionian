<?php
namespace Ionian\Errors\Exceptions;

/**
 * 405 Method Not Allowed
 * A request was made of a resource using a request method not supported by that resource;
 * for example, using GET on a form which requires data to be presented via POST, or using PUT on a read-only resource.
 */
Class HTTPException_405 extends HTTPException{
    public function __construct($message = 'The used method (HTTP verb) is not allowed for this resource.') {
        parent::__construct("Method Not Allowed", 405, $message);
    }
}