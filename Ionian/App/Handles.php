<?php
namespace Ionian\App;

use Ionian\Core\Spawner;
use Ionian\Errors\Exceptions\HTTPException_404;
use Ionian\Errors\Exceptions\HTTPException_405;
use Ionian\Errors\Exceptions\HTTPException_500;
use Ionian\Request\Request;
use ReflectionMethod;


/**
 * Class Handles
 *
 * Handles allows for creating aliased routes
 *
 * POST /UserController/RegisterAction
 * can be aliased using this class to
 * POST /u/r
 *
 * @package Ionian\App
 */
class Handles extends App{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    protected $routes = [];

    public function get($uri, $target) {
        $this->addRoute(self::METHOD_GET, $uri, $target);
    }

    public function post($uri, $target) {
        $this->addRoute(self::METHOD_POST, $uri, $target);
    }

    public function put($uri, $target) {
        $this->addRoute(self::METHOD_PUT, $uri, $target);
    }

    public function del($uri, $target) {
        $this->addRoute(self::METHOD_DELETE, $uri, $target);
    }

    public function multi(array $methods, $uri, $target) {
        foreach ($methods as $method) {
            $this->addRoute($method, $uri, $target);
        }
    }

    /**
     * Routes are stored in the following format:
     * [ "uri/uri/uri" =>   [
     *                          "GET" => ["controller" => controller, "action" => action],
     *                          "POST"=> ["controller" => controller, "action" => action],
     *                          ...
     *                      ],
     *  ...
     * ]
     * @return array
     */
    public function getRoutes(){
        return $this->routes;
    }

    protected function addRoute($method, $uri, $target) {
        $uri = '/' . trim($uri, "/");

        if(!in_array($method, [self::METHOD_GET, self::METHOD_POST, self::METHOD_DELETE, self::METHOD_DELETE]))
            throw new HTTPException_500("Route cannot be method '$method'. Only GET, POST, PUT and DELETE allowed.");

        if(isset($this->routes[$uri][$method]))
            throw new HTTPException_500("Route '$method $uri' is defined multiple times in the routing table");

        //Validate the existence of @ sign
        $at = strpos($target, "@");

        //Trigger error if @ symbol is not found in the right place! Right place is IndexController@TestAction
        if (($at === false) || ($at === 0) || ($at === strlen($target) - 1))
            throw new HTTPException_500("$target for $uri invalid. Target formatting is not valid.");


        //Check if we only have 1x @ sign
        $target = explode("@", $target);

        if (count($target) != 2)
            throw new HTTPException_500("$target for $uri invalid. Target formatting is not valid.");

        $this->routes[$uri][$method] = ["controller" => '\\Project\\Controllers\\' . $target[0], "action" => $target[1]];
    }

    public function run() {
        $request = Request::getInstance();
        $uri = $request->getRequestedRoute();
        $method = $request->getMethod();

        //This is what we are after
        $target = false;

        //If root was requested
        if(empty($uri) && isset($this->routes["/"])){
            $target = $this->routes["/"];
        }
        else{
            $uriString = '/' . implode("/", $uri);

            if(isset($this->routes[$uriString])){
                $target = $this->routes[$uriString];
            }
        }

        //If the URI route was found regardless of HTTP VERB (method)
        if ($target === false)
            throw new HTTPException_404;

        //If route was found but the method was not allowed
        if(!isset($target[$method]))
            throw new HTTPException_405;

        $target = $target[$method];

        if (!method_exists($target["controller"], $target["action"]))
            throw new HTTPException_500("Route target was not found.");


        $classMethod = new ReflectionMethod($target["controller"], $target["action"]);
        $requiredArgs = $classMethod->getNumberOfRequiredParameters();

        if($requiredArgs > 0)
            throw new HTTPException_500("Handles routing does not support action arguments in {$target["action"]}.");

        $obj = new $target["controller"]($this->db);
        $obj->{$target["action"]}();
    }
}