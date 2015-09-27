<?php
namespace Ionian\App;

use Ionian\Errors\Exceptions\HTTPException_400;
use Ionian\Errors\Exceptions\HTTPException_404;
use ReflectionMethod;

class Rapid extends App {
    public function run() {
        $resource = $this->getRequestedRoute();

        if(count($resource) >= 2){
            $controller = '\\Project\\Controllers\\'. ucfirst($resource[0]) . "Controller";
            $action = ucfirst($resource[1]) . "Action";
            $params = array_slice($resource, 2);
            foreach($params as &$param){
                $param = urldecode($param);
            }

            if(method_exists($controller, $action)){
                $classMethod = new ReflectionMethod($controller, $action);
                $requiredArgs = $classMethod->getNumberOfRequiredParameters();
                $totalArgs = $classMethod->getNumberOfParameters();
                $suppliedArgs = count($params);

                if(($suppliedArgs >= $requiredArgs) && ($suppliedArgs <= $totalArgs)){
                    $obj = new $controller();
                    call_user_func_array(array($obj, $action), $params);
                }
                else
                    throw new HTTPException_400("Missing URL Parameters.");
            }
            else
                throw new HTTPException_404;
        }
        else
            throw new HTTPException_400;
    }
}