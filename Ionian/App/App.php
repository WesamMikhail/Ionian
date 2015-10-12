<?php
namespace Ionian\App;

use Ionian\Errors\ExceptionHandler;
use Ionian\Errors\Exceptions\HTTPException;
use Ionian\Errors\Exceptions\HTTPException_500;
use Exception;
use PDO;

abstract Class App{
    const APP_MODE_DEV = 0;
    const APP_MODE_PROD = 1;

    protected $mode;
    protected $db;

    function __construct($mode){
        $this->setAppMode($mode);
    }

    public function setAppMode($mode){
        if($mode !== self::APP_MODE_DEV && $mode !== self::APP_MODE_PROD)
            throw new HTTPException_500("App mode is not supported");

        $this->mode = $mode;

        if($mode === App::APP_MODE_PROD) {
            error_reporting(0);

            set_exception_handler(function(\Exception $e){
                $status = "Internal Server Error";
                $code = $e->getCode();
                $message = $e->getMessage();

                if($e instanceof HTTPException){
                    $status = $e->getStatus();
                }

                if($code == 0){
                    $code = 500;
                }

                ExceptionHandler::handleJSON($code, $status, $message);
            });

            set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                throw new HTTPException_500;
            });

            register_shutdown_function(function(){
                $error = error_get_last();

                if($error !== null) {
                    ExceptionHandler::handleJSON(500, "Internal Server Error", "Unexpected Error.");
                }
            });
        }
    }

    public function getDb() {
        return $this->db;
    }


    public function setDb(PDO $db) {
        $this->db = $db;
    }



    abstract public function run();
}