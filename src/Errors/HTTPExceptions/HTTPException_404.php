<?php
namespace Lorenum\Ionian\Errors\HTTPExceptions;

/**
 * 404 Not Found
 * The requested resource could not be found but may be available again in the future.
 * Subsequent requests by the client are permissible.
 *
 * @package Lorenum\Ionian\Errors\HTTPExceptions
 */
Class HTTPException_404 extends HTTPException{
    public function __construct($message = 'Resource not found.') {
        parent::__construct("Not Found", 404, $message);
    }
}