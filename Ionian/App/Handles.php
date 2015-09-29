<?php
namespace Ionian\App;

use Exception;
use Ionian\Errors\Exceptions\HTTPException_400;
use Ionian\Errors\Exceptions\HTTPException_500;
use ReflectionMethod;

use Ionian\Errors\Exceptions\HTTPException_404;
use Ionian\Errors\Exceptions\HTTPException_405;

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

    protected $routes = [
        'GET'       => [],
        'POST'      => [],
        'PUT'       => [],
        'DELETE'    => []
    ];

    private $verbs = [
        self::METHOD_GET,
        self::METHOD_DELETE,
        self::METHOD_POST,
        self::METHOD_PUT
    ];

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

    protected function addRoute($method, $uri, $target) {

        ///Check if verb is allowed
        if (!in_array($method, $this->verbs))
            throw new HTTPException_405;

        //Check if both target and uri are valid strings
        if (!is_string($target) || !is_string($uri))
            throw new Exception("The uri '$uri' and target '$target' must both be strings.");


        //Clean URI
        $uri = '/' . trim($uri, "/");

        if (isset($this->routes[$method][$uri]))
            throw new Exception("$method $uri already defined.");

        //Validate the existence of @ sign
        $at = strpos($target, "@");

        //Trigger error if @ symbol is not found in the right place! Right place is IndexController@TestAction
        if (($at === false) || ($at === 0) || ($at === strlen($target) - 1))
            throw new Exception("$target for $uri invalid. Use @ sign between controller and action (ex. UserController@indexAction).");


        //Check if we only have 1x @ sign
        $target = explode("@", $target);

        if (count($target) != 2)
            throw new Exception("$target for $uri contains too many @ symbols!");

        //Add route
        $this->routes[$method][$uri] = ["controller" => '\\Project\\Controllers\\' . $target[0], "action" => $target[1]];
    }


    public function run() {
        $uri = $this->getRequestedRoute();
        $method = $_SERVER["REQUEST_METHOD"];
        $target = false; //This is what we are after
        $params = [];

        //If root requested
        if(count($uri) === 1 && $uri[0] === "/"){
            if(isset($this->routes[$method]["/"]))
                $target = $this->routes[$method]["/"];
        }
        else{
            $uriCount = count($uri);

            for($i = $uriCount - 1; $i >= 0; $i--){
                $uriString = '/' . implode("/", array_slice($uri, 0, $i + 1));

                //If uri not found, go on with the loop
                if(!isset($this->routes[$method][$uriString]))
                    continue;

                $target = $this->routes[$method][$uriString];
                $params = array_slice($uri, $i + 1, $uriCount - 1);

                foreach($params as &$param){
                    $param = urldecode($param);
                }
                break;
            }
        }

        if ($target === false)
            throw new HTTPException_404;

        if (!method_exists($target["controller"], $target["action"]))
            throw new HTTPException_500("Internal error while routing. Please contact system admin.");

        $classMethod = new ReflectionMethod($target["controller"], $target["action"]);
        $requiredArgs = $classMethod->getNumberOfRequiredParameters();
        $totalArgs = $classMethod->getNumberOfParameters();
        $numParams = count($params);

        //Check if the function referred requires the right number of params
        if (($numParams >= $requiredArgs) && ($numParams <= $totalArgs)) {
            //Run the route with the url-decoded arguments
            $obj = new $target["controller"]();
            call_user_func_array(array($obj, $target["action"]), $params);
        }
        else
            throw new HTTPException_400("Invalid number of parameters supplied.");
    }
}