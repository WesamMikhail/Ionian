<?php
namespace Project\Handlers;

use Ionian\Errors\ErrorHandler;

class CustomErrorHandler extends ErrorHandler{

    public function badRequest(){
        header($this->protocol . " 400 Bad Request.");
    }

    public function unauthorized(){
        header($this->protocol . " 401 Unauthorized Resource.");
    }

    public function notFound(){
        header($this->protocol . " 404 Page Not Found!");
        echo "sample custom 404 override!";
    }

    public function internalServerError() {
        header($this->protocol . " 500 Internal Server Error!");
    }

    public function unavailable(){
        header($this->protocol . " 503 Service Unavailable!");
    }

    public function customError($code, $error, $msg) {
        // TODO: Implement customError() method.
    }
}