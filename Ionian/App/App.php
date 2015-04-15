<?php
namespace Ionian\App;

use Ionian\Errors\ErrorHandlerInterface;
use Ionian\Errors\APIErrorHandler;
use Ionian\Errors\SiteErrorHandler;

use Ionian\Database\Database;

Abstract Class App{
    const APP_MODE_DEV = 0;
    const APP_MODE_PROD = 1;

    protected $errorHandler;

    function __construct($appMode, ErrorHandlerInterface $errorHandler = null){
        $this->setAppMode($appMode);

        if($errorHandler === null)
            $this->setErrorHandler(new APIErrorHandler());
        else{
            $this->setErrorHandler($errorHandler);
        }
    }

    public function setAppMode($mode){
        if($mode === self::APP_MODE_DEV){
            ini_set('error_reporting', E_ALL);
            ini_set('display_errors', '1');
        }
        else if($mode === self::APP_MODE_PROD){
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

    public function getErrorHandler(){
        return $this->errorHandler;
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
                $this->errorHandler->badRequest();
                die();
            }
        }
        return (empty($resource)) ? "/" : $resource;
    }

    abstract public function run();
}