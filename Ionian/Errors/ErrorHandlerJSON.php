<?php
namespace Ionian\Errors;

class ErrorHandlerJSON extends ErrorHandler {
    public function badRequest() {
        $this->output(400, "Bad Request", "Parameter missing or malformed URL");
    }

    public function unauthorized() {
        $this->output(401, "Unauthorized Resource", "You don't have permission to access this");
    }

    public function notFound() {
        $this->output(404, "Page Not Found", "");
    }

    public function internalServerError() {
        $this->output(500, "Internal Server Error", "Please contact server administrator");
    }

    public function unavailable() {
        $this->output(503, "Service Unavailable", "Please try again later");
    }

    public function conflict(){
        $this->output(503, "Conflict", "You are trying to access a resource that is already in use");
    }

    public function customError($code, $error, $msg) {
        $this->output($code, $error, $msg);
    }

    protected function output($code, $error, $msg){
        header($this->protocol . " $code $error");
        header('Content-Type: application/json');
        print_r(json_encode(["code" => $code, "error" => "$error - $msg"], JSON_PRETTY_PRINT));
    }

}