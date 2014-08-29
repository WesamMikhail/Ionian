<?php
//TODO make different routing classes.
//First class can be /controller/action based
//Second class can be /resource/ID
//Third class...

/* AUTOLOADER */
function __autoload($class) {
    $class = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
    require_once $class;
}

/* REDEFINE THESE VARIABLES FOR YOUR PROJECT! */
define('ROOT', dirname(__FILE__));
define('DEVELOPER', true);
define('SERVICE_DOMAIN', ""); //The site domain to be used in various libraries
define('APPLICATION_NAME', "FRAMEWORK"); //Application name to be used in various libraries

define('APPLICATION_FOLDER', ""); //Start folder. Use this if no Virtual Hosts are setup, else leave empty!
define('CSS_FOLDER' , APPLICATION_FOLDER . "/views/css/");
define('IMG_FOLDER' , APPLICATION_FOLDER . "/views/images/");
define('JS_FOLDER' , APPLICATION_FOLDER . "/views/js/");


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
$response->setResponseCodes(array(
    "200" => "Success!",
    "400" => "Bad Request. The Request is not complete. Parameters might be missing!",
    "401" => "Unauthorized Resource / Incorrect Password!",
    "403" => "Authentication Required!",
    "404" => "Invalid Request or Resource!",
    ));


/* PARSE INCOMING REQUEST */
$uri = explode("/", parse_url(rtrim(strtolower($_SERVER["REQUEST_URI"]), "/"), PHP_URL_PATH));
$script = explode("/", rtrim(strtolower($_SERVER["SCRIPT_NAME"]), "/"));

//Match URI vs SCRIPT_NAME in order to enable subdirectory support!
for($i= 0;$i < sizeof($script);$i++){
    if ((isset($uri[$i])) && ($uri[$i] == $script[$i]))
        unset($uri[$i]);
}

$path = array_values($uri);



//TODO change router to OOP

$controller = "";
$action = "";
$params = array();


//If request made to ROOT /
if(count($path) == 0){
    $controller = "Controllers\\HomeController";
    $action = "viewAction";
}

//IF request made to /controller add /index as action
else if(count($path) == 1){
    $controller = "Controllers\\" . $path[0] . "Controller";
    $action = "indexAction";
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