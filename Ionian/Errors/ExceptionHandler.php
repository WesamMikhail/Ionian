<?php
namespace Ionian\Errors;

class ExceptionHandler{
    public static function handleJSON($code, $status, $message){
        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1');
        header($protocol . " $code $status");
        header('Content-Type: application/json');
        print_r(json_encode(["code" => $code, "status" => $status, "message" => $message], JSON_PRETTY_PRINT));
    }
}