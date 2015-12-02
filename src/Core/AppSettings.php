<?php
namespace Lorenum\Ionian\Core;

use Lorenum\Ionian\Request\Request;
use Lorenum\Ionian\Response\ResponseInterface;
use Lorenum\Ionian\Routers\RouterInterface;
use Lorenum\Utils\Validator;

use PDO;

/**
 * Class AppSettings
 * A simple settings container to be used by the App class.
 * It contains everything from the Project scope namespace to the instances that will be injected into whichever class needs them
 *
 * @package Lorenum\Ionian\Core
 */
class AppSettings {

    /**
     * @var string
     */
    protected $controllerNamespace = '\\Project\\Controllers\\';

    /**
     * @var string
     */
    protected $modelNamespace = '\\Project\\Models\\';

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var PDO
     */
    protected $db;

    /**
     * @var ResponseInterface
     */
    protected $response;

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
     * @return string
     */
    public function getControllerNamespace() {
        return $this->controllerNamespace;
    }

    /**
     * @param string $controllerNamespace
     */
    public function setControllerNamespace($controllerNamespace) {
        if(!Validator::endsWith($controllerNamespace, "\\"))
            $controllerNamespace = $controllerNamespace . "\\";
        $this->controllerNamespace = $controllerNamespace;
    }

    /**
     * @return String
     */
    public function getModelNamespace() {
        return $this->modelNamespace;
    }

    /**
     * @param string $modelNamespace
     */
    public function setModelNamespace($modelNamespace) {
        if(!Validator::endsWith($modelNamespace, "\\"))
            $modelNamespace = $modelNamespace . "\\";
        $this->modelNamespace = $modelNamespace;
    }
}