<?php
namespace Lorenum\Ionian\Errors\HTTPExceptions;

/**
 * 509 Bandwidth Limit Exceeded (Apache bw/limited extension)
 * This status code is not specified in any RFCs. Its use is unknown.
 */
Class HTTPException_509 extends HTTPException{
    public function __construct($message = 'Bandwidth limit exceeded.') {
        parent::__construct("Bandwidth Limit Exceeded", 509, $message);
    }
}