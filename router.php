<?php
/* AUTOLOADER */
function __autoload($class) {
    $class = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
    require_once $class;
}

/* REDEFINE THESE VARIABLES FOR YOUR PROJECT! */
define('ROOT', dirname(__FILE__));
define('DEVELOPER', true);
define('SERVICE_DOMAIN', ""); //The site domain
define('APPLICATION_NAME', ""); //Application name to be used in various libraries

//Set error reporting mode for debugging
if (DEVELOPER) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', '1');
}
else {
    ini_set('display_errors', '0');
    error_reporting(0);
}


/* DB CONNECTION. UNCOMMENT IF NEEDED */
#$db = new Core\PDOExtension("mysql", "host", "db", "user", "password");


/* RESPONSE RENDERER. CAN RENDER JSON/XML/JSONP API OR REGULAR TEMPLATE VIEW*/
$response = new Core\ResponseHandler();
#$response->addResponseCodes(array("999" => "Some Error Msg!")); //ADD response codes if you need to use them for the API!


/* PARSE INCOMING REQUEST */
$uri = explode("/", parse_url(rtrim(strtolower($_SERVER["REQUEST_URI"]), "/"), PHP_URL_PATH));
$script = explode("/", rtrim(strtolower($_SERVER["SCRIPT_NAME"]), "/"));

//Match URI vs SCRIPT_NAME in order to enable subdirectory support!
for($i= 0;$i < sizeof($script);$i++){
    if ((isset($uri[$i])) && ($uri[$i] == $script[$i]))
        unset($uri[$i]);
}

$path = array_values($uri);

$controller = "";
$action = "";
$params = array();


//If request made to ROOT /
if(count($path) == 0){
    $controller = "Controllers\\HomeController";
    $action = "viewAction";
}

//If request made to /controller/action
else if(count($path) >= 2){
    $controller = "Controllers\\" . $path[0] . "Controller";
    $action = $path[1] . "Action";
    $params = array_slice($path, 2);
}

if(empty($controller) || (!is_readable($controller . ".php")) || (!method_exists($controller, $action))){
    $controller = "Controllers\\ErrorsController";
    $action = "notfoundAction";
}
else{
    $classMethod = new ReflectionMethod($controller, $action);
    $funcArgs = $classMethod->getNumberOfRequiredParameters();

    if(count($params) < $funcArgs){
        $controller = "Controllers\\ErrorsController";
        $action = "notcompleteAction";
    }
}

/* INITIATE REQUEST */
$controller = new $controller($response);
if(isset($db)) $controller->setDB($db);
call_user_func_array(array($controller, $action), $params); //Pass in params as method arguments