<?php
namespace Ionian\App;

use ReflectionMethod;

class Defined extends App {
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    protected $routes = array(
        'GET'       => array(),
        'POST'      => array(),
        'PUT'       => array(),
        'DELETE'    => array()
    );

    public function get($uri, $target, $preq = null) {
        $this->addRoute(self::METHOD_GET, $uri, $target, $preq);
    }

    public function post($uri, $target, $preq = null) {
        $this->addRoute(self::METHOD_POST, $uri, $target, $preq);
    }

    public function put($uri, $target, $preq = null) {
        $this->addRoute(self::METHOD_PUT, $uri, $target, $preq);
    }

    public function del($uri, $target, $preq = null) {
        $this->addRoute(self::METHOD_DELETE, $uri, $target, $preq);
    }

    public function multi(array $methods, $uri, $target, $preq = null) {
        foreach ($methods as $method) {
            if (!in_array($method, [self::METHOD_GET, self::METHOD_DELETE, self::METHOD_POST, self::METHOD_PUT])) {
                trigger_error("Method ($method) not applicable. Please only use GET, PUT, POST or DELETE in multiRoute([],...)", E_USER_ERROR);
            }

            $this->addRoute($method, $uri, $target, $preq);
        }
    }

    //TODO fix trigger_error messages!
    //TODO add preq support!
    protected function addRoute($method, $uri, $target, $preq = null) {

        if (!is_string($target) || !is_string($uri)) {
            trigger_error("Route URI and TARGET parameters must both be strings!", E_USER_ERROR);
        }

        //Clean URI
        $uri = '/' . trim($uri, "/");

        if (isset($this->routes[$method][$uri])) {
            trigger_error("Path $uri already defined!", E_USER_ERROR);
        }

        $at = strpos($target, "@");

        //Trigger error if @ symbol is not found in the right place! Right place is IndexController@TestAction
        if (($at === false) || ($at === 0) || ($at === strlen($target) - 1)) {
            trigger_error("$target for $uri is not a valid target!", E_USER_ERROR);
        }

        $target = explode("@", $target);

        if (count($target) != 2) {
            trigger_error("$target for $uri contains too many @ symbols!", E_USER_ERROR);
        }

        $this->routes[$method][$uri]["route"] = ["controller" => '\\Project\\Controllers\\' . $target[0], "action" => $target[1]];
    }

    public function run() {
        $uri = $this->getRequestedRoute();
        $uriCount = count($uri);
        $route = false;
        $params = [];

        if (!is_array($uri))
            $route = $this->findRoute($_SERVER["REQUEST_METHOD"], $uri, 0);

        else {
            for ($i = 0; $i < $uriCount; $i++) {
                $uriString = '/' . implode("/", array_slice($uri, 0, count($uri) - $i));
                $route = $this->findRoute($_SERVER["REQUEST_METHOD"], $uriString, $i);

                if (is_array($route)) {
                    $params = array_slice($uri, $uriCount - $i, $uriCount - 1);
                    break;
                }
            }
        }

        if ($route === false)
            $this->errorHandler->notFound();

        else {
            $obj = new $route["controller"]($this->getErrorHandler());
            call_user_func_array(array($obj, $route["action"]), $params);
        }
    }

    private function findRoute($method, $uri, $numParams) {

        //Check if the route does not exist
        if(!isset($this->routes[$method][$uri]))
            return false;

        //If it is predefined, grab the C/A to run
        $controller = $this->routes[$method][$uri]["route"]["controller"];
        $action = $this->routes[$method][$uri]["route"]["action"];

        //Check if C/A exists
        if (method_exists($controller, $action)) {
            $classMethod = new ReflectionMethod($controller, $action);
            $requiredArgs = $classMethod->getNumberOfRequiredParameters();
            $totalArgs = $classMethod->getNumberOfParameters();

            //Check if the function referred requires the right number of params
            if (($numParams >= $requiredArgs) && ($numParams <= $totalArgs))
                return $this->routes[$method][$uri]["route"];
        }

        //Return false if method does not exist or number of arguments required arguments is not satisfied
        return false;
    }
}