<?php
namespace Project\Handlers;

use Ionian\Errors\ErrorHandler_inter;

class CustomErrorHandler implements ErrorHandler_inter{

    public function badRequest() {
        echo "Custom 400 Error";
    }

    public function notFound() {
        echo "Custom 404 Error";
    }

    public function unauthorized() {
        echo "Custom 401 Error";
    }

    public function unavailable() {
        echo "Custom 503 Error. Service unavailable. Please try again later!";
    }
}