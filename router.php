<?php
//TODO redefine for project
define('ROOT', dirname(__FILE__));
define('DEVELOPER', true);
define('SERVICE_DOMAIN', "");                   //The site domain
define('APPLICATION_NAME', "");                 //Application name to be used in various libraries

//Set error reporting mode for debugging
if(DEVELOPER){
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', '1');
}
else{
    ini_set('display_errors', '0');
    error_reporting(0);
}

/* IF YOU NEED DB ACCESS UNCOMMENT AND EDIT THESE CONSTANTS */
//define('MYSQL_HOST', "");
//define('MYSQL_DB', "");
//define('MYSQL_USER', "");
//define('MYSQL_PASSWORD', "");


/* IF YOU NEED SESSION ACCESS UNCOMMENT AND EDIT THESE CONSTANTS */
//define('SESSION_LIFETIME', 86400);                                                  //Session lifetime in seconds - set to 24h default
//session_start();                                                                    //Session always active
//session_set_cookie_params(SESSION_LIFETIME, '/', '.' . SERVICE_DOMAIN);             //Session configurations

//AUTOLOADER
function __autoload($class){
    $class = str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';

    if (is_readable(ROOT . "/core/" . $class))
        require_once ROOT . "/core/" . $class;

    else if (is_readable(ROOT . "/controllers/" . $class))
        require_once ROOT . "/controllers/" . $class;

    else if (is_readable(ROOT . "/libraries/" . $class))
        require_once ROOT . "/libraries/" . $class;
}

//Handle request via resource routing. Each param position associated with an ID according to the routing rule you enter below!
//URI Routing is based on: /RESOURCE/:PARAM_ID/:PARAM_ID/:PARAM_ID. EX:
//RAW RULE                    /view/:view_id/:referrer/:api_key         "home@view"
//Translated URI:       DOMAIN/view/12345678/facebook/ABC123            HomeController->ViewAction()
$request = new requestHandler();
$request->route("/api", "home@api");
$request->route("/view","home@view");
$request->route("/view/:testparam","home@test");
$request->matchRoute();


//ResponseHandler compiles the response data into either a VIEW or API data via JSON/XML or JSONP
$response = new ResponseHandler();

//ADD response codes if you need to use them for the API!
//$response->addResponseCodes(array("999" => "Some Error Msg!"));


//Initiate the request according to the parsed requested resource
$controller = new $request->controller($request->params, $response);
$controller->{$request->action}();

