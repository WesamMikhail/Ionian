<?php
namespace Ionian\Errors;

class ErrorHandler implements ErrorHandler_inter{
    public function badRequest(){
        echo "400 bad request. Most likely due to missing parameters or malformed URL";
    }

    public function notFound(){
        echo "404 not found";
    }

    public function unauthorized(){
        echo "401 you don't have permission to access this resource";
    }

    public function unavailable(){
        echo "503 Service unavailable. Please try again later!";
    }

}