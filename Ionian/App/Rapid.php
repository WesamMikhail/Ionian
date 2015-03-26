<?php
namespace Ionian\App;

use ReflectionMethod;

class Rapid extends App {
    public function run() {
        $resource = $this->getRequestedRoute();

        if(count($resource) >= 2){
            $controller = '\\Project\\Controllers\\'. ucfirst($resource[0]) . "Controller";
            $action = ucfirst($resource[1]) . "Action";
            $params = array_slice($resource, 2);

            if(method_exists($controller, $action)){
                $classMethod = new ReflectionMethod($controller, $action);
                $requiredArgs = $classMethod->getNumberOfRequiredParameters();
                $totalArgs = $classMethod->getNumberOfParameters();
                $suppliedArgs = count($params);

                if(($suppliedArgs >= $requiredArgs) && ($suppliedArgs <= $totalArgs)){
                    $obj = new $controller($this->getErrorHandler());
                    call_user_func_array(array($obj, $action), $params);

                    return true;
                }
                else{$this->errorHandler->badRequest();}

            }
            else{$this->errorHandler->notFound();}

        }
        else{$this->errorHandler->badRequest();}
    }
}