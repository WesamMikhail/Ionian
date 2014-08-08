<?php
//AUTOLOADER
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


//Database Handler in case DB connection is needed. Replace the current line with the commented one
$db = null;
#$db = new Core\PDOExtension("mysql", "host", "db", "user", "password");

//Handle each request via resource routing. Everything is case-insensitive!
//Ex.       DOMAIN.COM/News/art1234
//Route:    ("/news/:article_id", "news@getArticle")
$request = new Core\RequestHandler();
$request->route("/", "home@api");
$request->route("/api", "home@api");
$request->route("/view", "home@view");
$request->route("/view/:testparam", "home@test");
$request->route("/view/test/:testicles/:paniz", "home@test");
$request->matchRoute();

//ResponseHandler compiles the response data into either a VIEW or API data via JSON/XML or JSONP
$response = new Core\ResponseHandler();

//ADD response codes if you need to use them for the API!
#$response->addResponseCodes(array("999" => "Some Error Msg!"));


//Initiate the request according to the parsed requested resource
//TODO: pass the params to the fucntions as argument rather than class variable
$class = "Controllers\\" . $request->getController();
$controller = new $class($request->getParams(), $response, $db);
$controller->{$request->getAction()}();

