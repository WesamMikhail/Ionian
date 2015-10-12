<?php
namespace Ionian\App;

use Ionian\Errors\Exceptions\HTTPException_404;
use Ionian\Errors\Exceptions\HTTPException_405;
use Ionian\Errors\Exceptions\HTTPException_500;
use Ionian\Request\Request;
use Lorenum\SimpleRouter\Map;

class Defined extends App {
    protected $router;

    function __construct($mode){
        parent::__construct($mode);
        $this->router = new Map;
    }

    public function get($route, $resource){
        $this->router->get($route, '\\Project\\Controllers\\' . $resource);
    }

    public function post($route, $resource){
        $this->router->post($route, '\\Project\\Controllers\\' . $resource);
    }

    public function put($route, $resource){
        $this->router->put($route, '\\Project\\Controllers\\' . $resource);
    }

    public function delete($route, $resource){
        $this->router->delete($route, '\\Project\\Controllers\\' . $resource);
    }

    public function run() {
        $request = Request::getInstance();
        $uri = $request->getRequestedRoute();
        $method = strtoupper($request->getMethod());

        $match = $this->router->match($method, $uri);

        if($match === false)
            throw new HTTPException_404;

        else if ($match === true)
            throw new HTTPException_405;

        if (!method_exists($match["controller"], $match["action"]))
            throw new HTTPException_500("Route intended target was not found.");

        $obj = new $match["controller"]($this->db);
        call_user_func_array(array($obj, $match["action"]), $match["params"]);
    }
}