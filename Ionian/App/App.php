<?php
namespace Ionian\App;

use Ionian\Errors\ErrorHandlerInterface;
use Ionian\Errors\MainErrorHandler;
use Ionian\Database\Database;

Abstract Class App{
    const APP_MODE_DEV = 0;
    const APP_MODE_PROD = 1;

    protected $errorHandler;

    function __construct(){
        $this->setErrorHandler(new MainErrorHandler());
    }

    public function setAppMode($mode){
        if($mode == self::APP_MODE_DEV){
            ini_set('error_reporting', E_ALL);
            ini_set('display_errors', '1');
        }
        else if($mode == self::APP_MODE_PROD){
            ini_set('error_reporting', 0);
            ini_set('display_errors', '0');
        }
    }

    public function setErrorHandler(ErrorHandlerInterface $handler){
        $this->errorHandler = $handler;
    }

    public function initDatabase($driver, $host, $db, $user, $password, array $options = []){
        Database::create("DEFAULT", [$driver, $host, $db, $user, $password, $options]);
    }

    public function getAppName(){
        return $this->appName;
    }

    public function getErrorHandler(){
        return $this->errorHandler;
    }

    protected function getRequestedRoute(){
        $uri = explode("?", $_SERVER["REQUEST_URI"]);

        $uri = explode("/", rtrim($uri[0], "/"));
        $script = explode("/", $_SERVER["SCRIPT_NAME"]);

        for($i= 0;$i < sizeof($script);$i++){
            if ((isset($uri[$i])) && ($uri[$i] == $script[$i]))
                unset($uri[$i]);
        }

        $resource = array_values($uri);
        return (empty($resource)) ? "/" : $resource;
    }

    abstract public function run();
}