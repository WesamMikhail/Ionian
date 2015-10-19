<?php
namespace Lorenum\Ionian\Errors\Exceptions;

/**
 * 410 Gone
 * Indicates that the resource requested is no longer available and will not be available again.
 * This should be used when a resource has been intentionally removed and the resource should be purged.
 * Upon receiving a 410 status code, the client should not request the resource again in the future.
 * Clients such as search engines should remove the resource from their indices.
 */
Class HTTPException_410 extends HTTPException{
    public function __construct($message = 'Resource is permanently gone.') {
        parent::__construct("Gone", 410, $message);
    }
}