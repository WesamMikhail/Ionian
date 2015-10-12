<?php
namespace Ionian\Request;

use Ionian\Errors\Exceptions\HTTPException_400;
use Ionian\Errors\Exceptions\HTTPException_415;

class Request{
    const METHOD_POST   = 'POST';
    const METHOD_GET    = 'GET';
    const METHOD_PUT    = 'PUT';
    const METHOD_DELETE = 'DELETE';

    protected $method;
    protected $protocol;
    protected $domain;
    protected $url;
    protected $ip;
    protected $query = [];
    protected $body = [];
    protected $headers = [];

    protected static $instance = null;

    private function __clone(){}

    private function __construct(){
        $this->headers  = $this->parseHeaders();
        $this->query    = $this->parseQuery();
        $this->method   = $_SERVER["REQUEST_METHOD"];
        $this->domain   = $_SERVER["HTTP_HOST"];
        $this->url      = $_SERVER["REDIRECT_URL"];

        //Check HTTPS or HTTP. Server must be properly configured for this to work
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
            $this->protocol = "https";
        else
            $this->protocol = "http";


        //Get the IP - Guess at best
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $this->ip = $_SERVER['HTTP_CLIENT_IP'];

        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

        else
            $this->ip = $_SERVER['REMOTE_ADDR'];


        //Request body should not be parsed in GET requests
        if($this->method == "POST" ||  $this->method == "PUT")
            $this->body = $this->parseContent();
    }

    /**
     * Singleton pattern for Request object
     * @return Request
     */
    public static function getInstance(){
        if (!isset(self::$instance)) {
            self::$instance = new Request();
        }

        return self::$instance;
    }

    /**
     * Return a single item from the query string by its key
     * @param $key
     * @return mixed|null
     */
    public static function query($key){
        $object = self::getInstance();
        if(isset($object->query[$key]))
            return $object->query[$key];

        return null;
    }

    /**
     * Return a singe item from the body by its key
     * @param $key
     * @return mixed|null
     */
    public static function body($key){
        $object = self::getInstance();
        if(isset($object->body[$key]))
            return $object->body[$key];

        return null;
    }

    /**
     * Return a single item from the headers by its key
     * @param $key
     * @return mixed|null
     */
    public static function header($key){
        $object = self::getInstance();
        if(isset($object->headers[$key]))
            return $object->headers[$key];

        return null;
    }


    /**
     * Parses the HTTP headers that came with the request
     * @return array
     */
    protected function parseHeaders(){
        $headers = array();
        foreach(getallheaders() as $key => $value) {
            $key = str_replace(" ", "_", $key);
            $key = str_replace("-", "_", $key);

            $headers[$key] = $value;
        }
        return $headers;
    }

    /**
     * Returns the $_GET array. That super global is always correctly parsed
     * @return array
     */
    protected function parseQuery(){
        return $_GET;
    }

    /**
     * IF header::content-type is multipart OR x-www-form-urlencoded
     *  return $_POST
     *
     * else if header::content-type is application/json
     *  return json_decode(php:://input")
     *
     * else
     *  HTTPException_415
     *
     *
     * NOTE: Content-Type must be supplied for this to work on every non-GET request
     *
     * @return array
     * @throws HTTPException_400
     * @throws HTTPException_415
     */
    protected function parseContent(){
        if($this->containsJSON()) {
            $body = file_get_contents('php://input');
            $decoded = json_decode($body, true);

            if(strlen($body) > 0 && $decoded === null)
                throw new HTTPException_400("Malformed JSON object in the request body");

            return $decoded;
        }
        else if($this->containsMultipartForm() || $this->containsWWWForm())
            return $_POST;
        else
            throw new HTTPException_415;
    }


    /**
     * Check if the Content-Type header is multipart
     * @return bool
     */
    private function containsMultipartForm(){
        if(isset($this->headers["Content_Type"]) && (strpos($this->headers["Content_Type"], "multipart/form-data") !== false)){
            return true;
        }

        return false;
    }

    /**
     * Check if the Content-Type header is x-www-form-urlencoded
     * @return bool
     */
    private function containsWWWForm(){
        if(isset($this->headers["Content_Type"]) && (strpos($this->headers["Content_Type"], "application/x-www-form-urlencoded") !== false)){
            return true;
        }

        return false;
    }

    /**
     * Check if the Content-Type header is application/json
     * @return bool
     */
    private function containsJSON(){
        if(isset($this->headers["Content_Type"]) && (strpos($this->headers["Content_Type"], "application/json") !== false)) {
            return true;
        }
        return false;
    }



    /**
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getProtocol() {
        return $this->protocol;
    }

    /**
     * @return mixed
     */
    public function getDomain() {
        return $this->domain;
    }

    /**
     * @return mixed
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * @return array|mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * Don't trust this. It is merely the value of the header
     *
     * @return mixed
     */
    public function getIp() {
        return $this->ip;
    }

    /**
     * Returns the requested route (URL - (PROTOCOL + HOST))
     * The returned array contains everything starting from the slash after the .com (or any other TLD) until the end of the URL
     * @return array
     * @throws HTTPException_400
     */
    public function getRequestedRoute(){
        $uri = explode("?", $_SERVER["REQUEST_URI"]);

        $uri = explode("/", rtrim($uri[0], "/"));
        $script = explode("/", $_SERVER["SCRIPT_NAME"]);

        for($i= 0;$i < sizeof($script);$i++){
            if ((isset($uri[$i])) && (strtolower($uri[$i]) == strtolower($script[$i])))
                unset($uri[$i]);
        }

        $resource = array_values($uri);
        foreach($resource as $resourceItem){
            //If one of the URI fields is empty, we refuse to accept the request!
            if($resourceItem == ""){
                throw new HTTPException_400;
            }
        }
        return $resource;
    }
}