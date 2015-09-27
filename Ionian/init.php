<?php
define("ROOT", dirname(__DIR__));
define("PROJECT", ROOT . "/Project");

if(!defined("DIRECTORY_SEPARATOR ")){
    PHP_OS == "Windows" || PHP_OS == "WINNT" ? define("DIRECTORY_SEPARATOR ", "\\") : define("DIRECTORY_SEPARATOR ", "/");
}

//Get composer's autoloader
if(is_readable('vendor/autoload.php'))
    require_once 'vendor/autoload.php';
else
    throw new Exception("Run composer install.");