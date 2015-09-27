<?php
namespace Ionian\App;

use Ionian\Database\Database;
use Ionian\Errors\ExceptionHandler;
use Ionian\Errors\Exceptions\HTTPException;
use Ionian\Errors\Exceptions\HTTPException_400;
use Ionian\Errors\Exceptions\HTTPException_500;

use Exception;
use Ionian\Utils\Explorer;

abstract Class App{
    const APP_MODE_DEV = 0;
    const APP_MODE_PROD = 1;

    protected $mode;

    function __construct($mode){
        if($mode !== self::APP_MODE_DEV && $mode !== self::APP_MODE_PROD)
            throw new Exception("App mode is not supported");

        $this->setAppMode($mode);
    }

    public function setAppMode($mode){
        $this->mode = $mode;

        if($mode === App::APP_MODE_PROD) {
            error_reporting(0);

            set_exception_handler(function(\Exception $e){
                $status = "Unknown!";
                if($e instanceof HTTPException){
                    $status = $e->getStatus();
                }
                $code = $e->getCode();
                $message = $e->getMessage();

                ExceptionHandler::handleJSON($code, $status, $message);
            });

            set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                throw new HTTPException_500;
            });

            register_shutdown_function(function(){
                $error = error_get_last();

                if( $error !== NULL) {
                    ExceptionHandler::handleJSON(500, "Internal Server Error", "Unexpected Error.");
                }
            });
        }
    }

    public function initDatabase($driver, $host, $db, $user, $password, array $options = []){
        Database::create("DEFAULT", [$driver, $host, $db, $user, $password, $options]);
    }

    public function initDatabaseFromSettingsFile($file, $options = []){
        if(Explorer::getFileExtension($file) != "ini")
            throw new Exception("Settings file is not of extension .ini");

        $settings = parse_ini_file($file, true);

        if(!isset($settings["Database"]))
            throw new Exception("[Database] section is not found in $file");

        $db = $settings["Database"];

        Database::create("DEFAULT", [$db["db"], $db["host"], $db["database"], $db["user"], $db["password"], $options]);
    }

    protected function getRequestedRoute(){
        $uri = explode("?", $_SERVER["REQUEST_URI"]);

        $uri = explode("/", rtrim($uri[0], "/"));
        $script = explode("/", $_SERVER["SCRIPT_NAME"]);

        for($i= 0;$i < sizeof($script);$i++){
            if ((isset($uri[$i])) && (strtolower($uri[$i]) == strtolower($script[$i])))
                unset($uri[$i]);
        }

        $resource = array_values($uri);
        foreach($resource as $resourceItem){
            //If one of the URI fields is empty, we refuse to accept the request!
            if($resourceItem == ""){
                throw new HTTPException_400;
            }
        }
        return (empty($resource)) ? "/" : $resource;
    }

    abstract public function run();
}