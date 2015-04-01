<?php
namespace Ionian\App;

use Ionian\Errors\ErrorHandlerInterface;
use Ionian\Errors\APIErrorHandler;
use Ionian\Errors\SiteErrorHandler;

use Ionian\Database\Database;

Abstract Class App{
    const APP_MODE_DEV = 0;
    const APP_MODE_PROD = 1;

    const APP_TYPE_API = 1;
    const APP_TYPE_SITE = 2;

    protected $errorHandler;

    function __construct($type){
        $this->setAppType($type);
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

    public function setAppType($type){
        if($type === self::APP_TYPE_API){
            $this->setErrorHandler(new APIErrorHandler());
        }
        else if($type == self::APP_TYPE_SITE){
            $this->setErrorHandler(new SiteErrorHandler());
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
        return (empty($resource)) ? "/" : $resource;
    }

    abstract public function run();
}