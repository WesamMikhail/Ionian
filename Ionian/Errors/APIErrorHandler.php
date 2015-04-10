<?php
namespace Ionian\Errors;

class APIErrorHandler extends ErrorHandler {
    public function badRequest() {
        header($this->protocol . " 400 Bad Request.");
        header('Content-Type: application/json');
        print_r($this->template(400, "Bad Request. Parameter missing or malformed URL"));
    }

    public function unauthorized() {
        header($this->protocol . " 401 Unauthorized Resource.");
        header('Content-Type: application/json');
        print_r($this->template(401, "Unauthorized Resource. You don't have permission to access this!"));
    }

    public function notFound() {
        header($this->protocol . " 404 Page Not Found!");
        header('Content-Type: application/json');
        print_r($this->template(404, "Page Not Found!"));
    }

    public function internalServerError() {
        header($this->protocol . " 500 Internal Server Error!");
        header('Content-Type: application/json');
        print_r($this->template(503, "Internal Error. Please contact server administrator!"));
    }

    public function unavailable() {
        header($this->protocol . " 503 Service Unavailable!");
        header('Content-Type: application/json');
        print_r($this->template(503, "Service Unavailable. Please try again later!"));
    }

    public function conflict(){
        header($this->protocol . " 409 Conflict!");
        header('Content-Type: application/json');
        print_r($this->template(409, "Conflict. You are trying to access a resource that is already in use by someone else!"));
    }

    public function customError($code, $error, $msg) {
        header('Content-Type: application/json');
        header($this->protocol . " $code $error");
        print_r($this->template($code, $msg));
    }

    protected function template($code, $error) {
        $dump = ["code" => $code, "error" => $error];
        return json_encode($dump, JSON_PRETTY_PRINT);
    }

}