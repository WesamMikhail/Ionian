<?php
namespace Lorenum\Ionian\Core;

use Lorenum\Ionian\Errors\ApplicationExceptions\ArgumentException;
use Lorenum\Ionian\Errors\HTTPExceptions\HTTPException_400;
use Lorenum\Ionian\Errors\HTTPExceptions\HTTPException_404;
use Lorenum\Ionian\Errors\HTTPExceptions\HTTPException_405;
use Lorenum\Ionian\Errors\HTTPExceptions\HTTPException_500;
use Lorenum\Ionian\Errors\ErrorHandler;
use Lorenum\Ionian\Errors\ApplicationExceptions\InstanceException;
use Lorenum\Ionian\Utils\Explorer;

use ReflectionMethod;

/**
 * Class App
 * The main application to be instantiated by the procedural script.
 * The application needs an ErrorMode flag in order to function properly depending on the environment.
 *
 * The App class knows only how to run itself according to the specified settings so make sure to include the correct settings
 * for your app to function properly.
 *
 * @package Lorenum\Ionian\Core
 */
class App {
    const MODE_DEV = 0;
    const MODE_PROD = 1;

    /**
     * @var AppSettings
     */
    public $settings;

    /**
     * Creating an application requires you to state what mode it will be created in, development or production.
     * use class constants App::MODE_*
     *
     * @param $mode
     * @throws HTTPException_500
     */
    function __construct($mode){
        if($mode !== App::MODE_DEV && $mode !== App::MODE_PROD)
            throw new HTTPException_500("App mode is not supported");

        //Dev mode spits out all errors no matter what
        if($mode === App::MODE_DEV){
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        //Production mode sanitizes all error displays into a response object
        if($mode === App::MODE_PROD) {
            error_reporting(0);
            ErrorHandler::registerExceptionHandler();
            ErrorHandler::registerErrorHandler();
            ErrorHandler::registerShutdownHandler();
        }

        $this->settings = new AppSettings();
    }

    /**
     * Runs the application according to the settings in the settings class variable.
     * Prior to run(), $app->settings must contain at least a 'Request object', a 'Response object' and a 'Router object'.
     *
     * @throws HTTPException_400
     * @throws HTTPException_404
     * @throws HTTPException_405
     * @throws InstanceException
     */
    public function run(){
        //Validate the content of settings
        if(is_null($this->settings->getRequest()) || is_null($this->settings->getResponse()) || is_null($this->settings->getRouter()))
            throw new ArgumentException("App settings must at least contain a 'Request object', a 'Response object' and a 'Router object'");

        //Generate a Route object based on the Request and Router object in the container
        $route = $this->settings->getRouter()->match($this->settings->getRequest());

        //If unable to find a route
        if($route === false)throw new HTTPException_404;

        //If route was found by the method was not allowed
        if($route === true) throw new HTTPException_405;

        //Fully qualify the controller's name
        $class = $this->settings->getControllerNamespace() . $route->getControllerName();

        //If the requested controller or action does not exist in the filesystem
        if(!Explorer::checkIfClassExists($class, $route->getActionName()))
            throw new HTTPException_404;

        //Spawn the controller from the fully qualified class name
        $controller = new $class($this->settings);

        //Return false of the requested controller is not inherited from the Controller parent class
        if(!is_subclass_of($class, "\\Lorenum\\Ionian\\Core\\Controller"))
            throw new InstanceException("Class '$class' does not inherit from '\\Lorenum\\Ionian\\Core\\Controller'");

        //Check if the Action requested has arguments that must be supplied
        $classMethod = new ReflectionMethod($controller, $route->getActionName());
        $requiredArgs = $classMethod->getNumberOfRequiredParameters();
        $totalArgs = $classMethod->getNumberOfParameters();
        $suppliedArgs = count($route->getParams());

        //If the correct number of arguments supplied
        if(($suppliedArgs >= $requiredArgs) && ($suppliedArgs <= $totalArgs)){
            call_user_func_array(array($controller, $route->getActionName()), $route->getParams());
        }
        else {
            throw new HTTPException_400("URL parameter count does not match the expected number");
        }
    }
}