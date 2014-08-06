<?php
class requestHandler {
    private $routeTable = array();
    public $controller;
    public $action;
    public $params = array();
    public $ip;

    function __construct() {
        $this->ip = $_SERVER["REMOTE_ADDR"];
    }


    /**
     * Set a pattern to match for routing
     * EX. route("/", "index@index") means that URI / will lead to IndexController indexAction
     *
     * @param $location
     * @param $destination
     */
    public function route($location, $destination) {
        //location us the URI, destination is the Resource
        $location = explode("/", ltrim($location, "/"));

        //The first element of the location is the targeted resource. Ex "/streams"
        //However the same target can have multiple parameters. Ex. "/streams/dota2" OR "/streams/all/twitch"
        //Each targeted resource can have multiple URI options, all are included in an array with each connected to a destination
        $this->routeTable["/" . $location[0]][count($location) - 1] = array("destination" => $destination);

        if (count($location) > 1) {
            $params = array();
            for ($i = 1; $i < count($location); $i++) {
                $params[] = $location[$i];
            }

            //We save the parameter IDs as specified by the route rule into an array inside of the route array
            $this->routeTable["/" . $location[0]][count($location) - 1]["params"] = $params;
        }
        //print_r($this->routeTable) to see how this method structures the routing tree!
    }

    /**
     * Match the route with the routing table provided through the route() method
     */
    public function matchRoute() {

        //Incoming request URI
        $path = explode("/", parse_url(ltrim($_SERVER["REQUEST_URI"], "/"), PHP_URL_PATH));

        //We check if the URI is identical to a pre-defined route
        if (isset($this->routeTable["/" . $path[0]][count($path) - 1])) {

            //Grab the route
            $route = $this->routeTable["/" . $path[0]][count($path) - 1];

            //Parse the controller and action
            $destination = explode("@", $route["destination"]);
            $this->controller = ucfirst($destination[0]) . "Controller";
            $this->action = $destination[1] . "Action";

            //Validate required params
            if (isset($route["params"])) {
                foreach ($route["params"] as $number => $id) {

                    //If exists, add the parameter to the params variable with the ID specified by the routing rule!
                    //The IDs are bound by location of the param. The first parameter gets the first ID, second one gets second ID, etc.
                    //Ex.
                    //routeRule:    "/home/:article_id/:seo_link
                    //URI:          "/home/21312/asdasd"
                    //This generates the following params array: array("article_id" => 21312, "seo_link"=> asdasd)
                    if (!empty($path[$number + 1]))
                        $this->params[ltrim($id, ":")] = $path[$number + 1];

                    else {
                        //If a parameter doesnt not exist, that means that the user give an incomplete URI
                        $this->controller = "ErrorsController";
                        $this->action = "notfoundAction";
                        return;
                    }
                }
            }
        }
        //If the URI not found among the routes...
        else {
            $this->controller = "ErrorsController";
            $this->action = "notfoundAction";
        }
    }

    /**
     * @return array
     */
    public function getRouteTable() {
        return $this->routeTable;
    }


}