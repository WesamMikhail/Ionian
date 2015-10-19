<?php
namespace Lorenum\Ionian\Errors\Exceptions;

/**
 * 403 Forbidden
 * The request was a valid request, but the server is refusing to respond to it.
 * Unlike a 401 Unauthorized response, authenticating will make no difference.
 */
Class HTTPException_403 extends HTTPException{
    public function __construct($message = 'Access to this resource is permanently forbidden regardless of auth status.') {
        parent::__construct("Forbidden", 403, $message);
    }
}