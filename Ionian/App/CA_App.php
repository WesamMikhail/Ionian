<?php
namespace Ionian\App;

use \ReflectionMethod;

class CA_App extends App {

    public function run(array $settings = array()) {
        $uri = explode("?", $_SERVER["REQUEST_URI"]);

        $uri = explode("/", rtrim($uri[0], "/"));
        $script = explode("/", $_SERVER["SCRIPT_NAME"]);

        for($i= 0;$i < sizeof($script);$i++){
            if ((isset($uri[$i])) && ($uri[$i] == $script[$i]))
                unset($uri[$i]);
        }

        $resource = array_values($uri);
        $resource = (empty($resource)) ? "/" : $resource;

        if(count($resource) >= 2){
            $controller = '\\Project\\Controllers\\'. ucfirst($resource[0]) . "Controller";
            $action = ucfirst($resource[1]) . "Action";
            $params = array_slice($resource, 2);

            if(method_exists($controller, $action)){
                $classMethod = new ReflectionMethod($controller, $action);
                $funcArgs = $classMethod->getNumberOfRequiredParameters();

                if($funcArgs == count($params)){
                    $obj = new $controller($this);
                    call_user_func_array(array($obj, $action), $params);

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