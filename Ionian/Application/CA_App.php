<?php
namespace Ionian\Application;

use \ReflectionMethod;

class CA_App extends App {
    public function run(array $settings = array()) {
        $resource = $this->request->getResource();

        if(count($resource) >= 2){
            $controller = '\\Project\\Controllers\\'. ucfirst($resource[0]) . "Controller";
            $action = ucfirst($resource[1]) . "Action";
            $params = array_slice($resource, 2);

            if(method_exists($controller, $action)){
                $classMethod = new ReflectionMethod($controller, $action);
                $funcArgs = $classMethod->getNumberOfRequiredParameters();

                if($funcArgs == count($params)){
                    echo "yaozaa!";
                    return true;
                }
                else{$this->errorHandler->badRequest();}

            }
            else{$this->errorHandler->notFound();}

        }
        else{$this->errorHandler->badRequest();}

        return false;
    }
}