<?php
namespace Lorenum\Ionian\Routers;

use Lorenum\Ionian\Request\Request;
use Lorenum\SimpleRouter\Map;

/**
 * Class Defined
 * Defined is this framework's RESTful router. It wraps around the Lorenum\SimpleRouter package.
 * This class has barely any functionality of its own. It is merely a wrapper that implements the routing interface
 *
 * @package Lorenum\Ionian\Routers
 */
class Defined implements RouterInterface{
    /**
     * @var Map
     */
    protected $simpleRouter;

    function __construct(){
        $this->simpleRouter = new Map;
    }

    /**
     * Assign GET route
     *
     * @param $route
     * @param $resource
     */
    public function get($route, $resource){
        $this->simpleRouter->get($route, $resource);
    }

    /**
     * Assign POST route
     *
     * @param $route
     * @param $resource
     */
    public function post($route, $resource){
        $this->simpleRouter->post($route, $resource);
    }

    /**
     * Assign PUT route
     *
     * @param $route
     * @param $resource
     */
    public function put($route, $resource){
        $this->simpleRouter->put($route, $resource);
    }

    /**
     * Assign DELETE route
     *
     * @param $route
     * @param $resource
     */
    public function delete($route, $resource){
        $this->simpleRouter->delete($route, $resource);
    }

    /**
     * @param Request $request
     * @return Route|boolean False if 404, true if 405. Route if successful match is found.
     */
    public function match(Request $request) {
        $uri = $request->getRequestedResource();
        $method = $request->getMethod();

        $match = $this->simpleRouter->match($method, $uri);

        if($match === false)
            return false;

        else if ($match === true)
            return true;

        $route = new Route();
        $route->setController($match["controller"]);
        $route->setAction($match["action"]);
        $route->setParams($match["params"]);

        return $route;

    }
}