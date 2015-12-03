<?php
namespace Lorenum\Ionian\Request;

/**
 * Class Parser
 * The parser class contains wrapping methods for creating a Request object based on the runtime environment.
 * Apache usually sets everything correctly into the globals so using Parser::parseFromGlobals() usually works just fine.
 * Other server software might require different parsing methods
 *
 * @package Lorenum\Ionian\Request
 */
class Parser{

    /**
     * Parses everything request related from the PHP globals into a Request object
     *
     * @return Request
     */
    public static function parseFromGlobals(){
        $request = new Request();
        $request->setMethod(strtoupper($_SERVER["REQUEST_METHOD"]));
        $request->setDomain($_SERVER["HTTP_HOST"]);
        $request->setUri($_SERVER["REQUEST_URI"]);
        $request->setScript($_SERVER["SCRIPT_NAME"]);
        $request->setQuery($_GET);
        $request->setProtocol($_SERVER['SERVER_PROTOCOL']); //TODO change to a more reliable method for determining HTTPs

        //Get the IP - Guess at best
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $request->setIp($_SERVER['HTTP_CLIENT_IP']);

        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $request->setIp($_SERVER['HTTP_X_FORWARDED_FOR']);

        else
            $request->setIp($_SERVER['REMOTE_ADDR']);


        //Set headers.
        $headers = array();
        if (!function_exists('getallheaders') && is_array($_SERVER))  {
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
        }
        else{
            foreach(getallheaders() as $key => $value) {
                $key = str_replace(" ", "_", $key);
                $key = str_replace("-", "_", $key);

                $headers[$key] = $value;
            }
        }

        $request->setHeaders($headers);


        //The body is only read in PUT and POST requests
        if($request->getMethod() == "POST" || $request->getMethod() == "PUT"){
            if(isset($headers["Content_Type"]) && (strpos($headers["Content_Type"], "multipart/form-data") !== false)){
                $request->setBody($_POST);
            }
            else if(isset($headers["Content_Type"]) && (strpos($headers["Content_Type"], "application/x-www-form-urlencoded") !== false)){
                $request->setBody($_POST);
            }
            else if(isset($headers["Content_Type"]) && (strpos($headers["Content_Type"], "application/json") !== false)){
                $body = file_get_contents('php://input');
                $request->setBody(json_decode($body, true));
            }
        }

        return $request;
    }
}