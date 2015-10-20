<?php
namespace Lorenum\Ionian\Errors\HTTPExceptions;

/**
 * 429 Too Many Requests
 * The user has sent too many requests in a given amount of time. Intended for use with rate limiting schemes
 */
Class HTTPException_429 extends HTTPException{
    public function __construct($message = 'Client sent too many requests.') {
        parent::__construct("Too Many Requests", 429, $message);
    }
}