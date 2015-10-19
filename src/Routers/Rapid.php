<?php
namespace Lorenum\Ionian\Routers;

use Lorenum\Ionian\Request\Request;

/**
 * Class Rapid
 * Rapid is the router for fast prototypical development. Using Rapid will simply make sure that the requested URL
 * is split as follows:
 *
 *  /controller/action/param1/param2/...
 *
 * Typically, rapid is used during the initial development phase and replaced by Defined when the routes are stable.
 *
 *
 * @package Lorenum\Ionian\Routers
 */
class Rapid implements RouterInterface {

    /**
     * @param Request $request
     * @return Route|boolean False if Request does not satisfy minimum route requirement
     */
    public function match(Request $request) {
        $resource = $request->getRequestedResource();

        if(count($resource) >= 2){
            $controller = ucfirst($resource[0]) . "Controller";
            $action = ucfirst($resource[1]) . "Action";
            $params = array_slice($resource, 2);
            foreach($params as &$param){
                $param = urldecode($param);
            }

            $route = new Route();
            $route->setController($controller);
            $route->setAction($action);
            $route->setParams($params);

            return $route;
        }

        //If requested resource cannot  match a route
        return false;
    }
}