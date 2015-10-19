<?php
namespace Lorenum\Ionian\Core;

use Lorenum\Ionian\Errors\Exceptions\HTTPException_400;
use Lorenum\Ionian\Errors\Exceptions\HTTPException_404;
use Lorenum\Ionian\Errors\Exceptions\HTTPException_405;
use Lorenum\Ionian\Errors\Exceptions\HTTPException_500;
use Lorenum\Ionian\Errors\ErrorHandler;
use Lorenum\Ionian\Request\Parser;
use Lorenum\Ionian\Request\Request;
use Lorenum\Ionian\Response\JSONResponse;
use Lorenum\Ionian\Response\ResponseInterface;
use Lorenum\Ionian\Routers\Rapid;
use Lorenum\Ionian\Routers\RouterInterface;
use Lorenum\Ionian\Factories\ControllerFactory;
use Lorenum\Ionian\Factories\ModelFactory;

use PDO;
use ReflectionMethod;

/**
 * Class App
 * This is the application model in which every class instance is injected.
 * The class instances are injected here because the App class knows how to handle dependencies.
 * It works as a form of "dumb" container.
 *
 * If no ControllerFactory is injected for instance, it will instead fallback on instantiating the default ControllerFactory.
 * The idea here is that you could inject your own classes with your own settings and this App module will know how to handle that.
 *
 * @package Lorenum\Ionian\Core
 */
class App {
    const MODE_DEV = 0;
    const MODE_PROD = 1;

    protected $request;
    protected $response;
    protected $modelFactory;
    protected $controllerFactory;
    protected $db;
    protected $router;

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
    }

    /**
     * @return PDO
     */
    public function getDb() {
        return $this->db;
    }

    /**
     * @param PDO $db
     */
    public function setDb(PDO $db) {
        $this->db = $db;
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request) {
        $this->request = $request;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response) {
        $this->response = $response;
    }

    /**
     * @return ModelFactory
     */
    public function getModelFactory() {
        return $this->modelFactory;
    }

    /**
     * @param ModelFactory $modelFactory
     */
    public function setModelFactory(ModelFactory $modelFactory) {
        $this->modelFactory = $modelFactory;
    }

    /**
     * @return ControllerFactory
     */
    public function getControllerFactory() {
        return $this->controllerFactory;
    }

    /**
     * @param ControllerFactory $controllerFactory
     */
    public function setControllerFactory(ControllerFactory $controllerFactory) {
        $this->controllerFactory = $controllerFactory;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter() {
        return $this->router;
    }

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router) {
        $this->router = $router;
    }

    /**
     * Runs the application by constructing each necessary object and injecting its dependencies.
     * This run procedure is the CORE glue of all the framework's pieces.
     *
     * If an object is missing and not injected, the App will fallback and create a default object that will take its place.
     *
     * @throws HTTPException_400
     * @throws HTTPException_404
     */
    public function run(){
        //Initiate fallback objects in case user never defined anything specific.
        $this->init();

        //Ask the specified router for a matching route
        $route = $this->getRouter()->match($this->getRequest());

        //If unable to find a route
        if($route === false)
            throw new HTTPException_404;

        //Inject the needed objects into the factories
        $this->getResponse()->setProtocol($this->getRequest()->getProtocol());
        $this->getModelFactory()->setDb($this->getDb());
        $this->getControllerFactory()->setRequest($this->getRequest());
        $this->getControllerFactory()->setModelFactory($this->getModelFactory());
        $this->getControllerFactory()->setResponse($this->getResponse());

        //After injecting everything, ask the controller factory for a controller instance
        $controller = $this->getControllerFactory()->get($route->getController(), $route->getAction());

        //If controller or action were not found in the code
        if($controller === false)
            throw new HTTPException_404;

        //If route was found by the method was not allowed
        if($controller === true)
            throw new HTTPException_405;

        //Check if the Action requested has arguments that must be supplied
        $classMethod = new ReflectionMethod($controller, $route->getAction());
        $requiredArgs = $classMethod->getNumberOfRequiredParameters();
        $totalArgs = $classMethod->getNumberOfParameters();
        $suppliedArgs = count($route->getParams());

        //If the correct number of arguments supplied
        if(($suppliedArgs >= $requiredArgs) && ($suppliedArgs <= $totalArgs)){
            call_user_func_array(array($controller, $route->getAction()), $route->getParams());
        }
        else {
            throw new HTTPException_400("URL parameter count does not match the expected number");
        }
    }

    /**
     * Initiate default fallback classes in case no user-defined ones has been inserted
     */
    protected function init(){
        if(!isset($this->request))
            $this->setRequest(Parser::parseFromGlobals());

        if(!isset($this->controllerFactory))
            $this->setControllerFactory(new ControllerFactory());

        if(!isset($this->modelFactory))
            $this->setModelFactory(new ModelFactory());

        if(!isset($this->router))
            $this->setRouter(new Rapid());

        if(!isset($this->response))
            $this->setResponse(new JSONResponse());
    }
}