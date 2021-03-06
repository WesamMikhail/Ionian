<?php
namespace Lorenum\Ionian\Errors;

use Lorenum\Ionian\Errors\HTTPExceptions\HTTPException;
use Lorenum\Ionian\Errors\HTTPExceptions\HTTPException_500;
use Lorenum\Ionian\Response\JSONResponse;

use Exception;

/**
 * Class ErrorHandler
 * This class is a static function container that allows us to register expected as well as unexpected error handlers.
 * In production mode you will most likely want your errors to be displayed in a safely manner.
 * This class contains a bunch of static functions that will allow you to do just that.
 *
 * @package Lorenum\Ionian\Errors
 */
class ErrorHandler{

    /**
     * ALL errors triggered by the user using "trigger_error" are caught and reformatted into a standard HTTPException_500
     */
    public static function registerErrorHandler(){
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            throw new HTTPException_500;
        });
    }

    /**
     * ALL unexpected fatal errors that cause a script shutdown are caught during termination time and reformatted into a HTTPException_500
     */
    public static function registerShutdownHandler(){
        register_shutdown_function(function(){
            $error = error_get_last();

            if($error !== null) {
                ErrorHandler::handleJSON(500, "Internal Server Error", "Unexpected error caused a fatal shutdown. Please contact the server administrator about this problem");
            }
        });
    }

    /**
     * ALL Exceptions are caught and formatted into a response object regardless of type.
     */
    public static function registerExceptionHandler(){
        set_exception_handler(function(Exception $e){
            $code = 500;
            $status = "Internal Server Error";
            $message = 'Please contact an administrator about this error';

            if($e instanceof HTTPException){
                $code = $e->getCode();
                $status = $e->getStatus();
                $message = $e->getMessage();
            }
            else{
                $message .= " - Internal Code: " . $e->getCode();
            }

            ErrorHandler::handleJSON($code, $status, $message);
        });
    }

    /**
     * Handle method that converts into a response object
     *
     * @param $code
     * @param $status
     * @param $message
     */
    public static function handleJSON($code, $status, $message){
        $response = new JSONResponse();
        $response->setProtocol($_SERVER['SERVER_PROTOCOL']);
        $response->setCode($code);
        $response->setStatus($status);
        $response->setMessage($message);
        $response->output();
    }
}