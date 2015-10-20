<?php
namespace Lorenum\Ionian\Errors\HTTPExceptions;

/**
 * 415 Unsupported Media Type
 * The request entity has a media type which the server or resource does not support.
 * For example, the client uploads an image as image/svg+xml, but the server requires that images use a different format.
 */
Class HTTPException_415 extends HTTPException{
    public function __construct($message = 'Unexpected Content-Type header.') {
        parent::__construct("Unsupported Media Type", 415, $message);
    }
}