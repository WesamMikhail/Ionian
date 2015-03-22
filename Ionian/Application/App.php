<?php
namespace Ionian\Application;

use \PDO;

Abstract Class App{
    const APP_MODE_DEV = 0;
    const APP_MODE_PROD = 1;

    protected $appName;
    protected $request;
    protected $errorHandler;
    protected $db;

    function __construct($name){
        $this->appName = $name;
        $this->request = new Request;
        $this->setErrorHandler(new ErrorHandler());
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

    public function setErrorHandler(ErrorHandler $handler){
        $this->errorHandler = $handler;
    }

    public function initPDO($driver, $host, $db, $user, $password, $options = null){
        $this->db = new PDO($driver . ":host=" . $host . ";dbname=" . $db, $user, $password, $options);
    }

    public function getDB(){
        return $this->db;
    }

    public function getAppName(){
        return $this->appName;
    }

    public function getErrorHandler(){
        return $this->errorHandler;
    }

    public function getRequest(){
        return $this->request;
    }

    abstract public function run(array $settings = array());
}