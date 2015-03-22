<?php
namespace Ionian\Application;

class Request {
    protected $requestTime;
    protected $scheme;
    protected $host;
    protected $scriptName;
    protected $requestURI;
    protected $resource;
    protected $query;
    protected $method;
    protected $userAgent;
    protected $remoteIP;
    protected $cookie;


    function __construct() {
        $this->setMethod($_SERVER["REQUEST_METHOD"]);
        $this->setRemoteIP($_SERVER["REMOTE_ADDR"]);
        $this->setScriptName($_SERVER["SCRIPT_NAME"]);
        $this->setRequestTime($_SERVER["REQUEST_TIME"]);
        $this->setQuery(isset($_SERVER['QUERY_STRING']) ? $_GET : '');
        $this->setHost($_SERVER["HTTP_HOST"]);
        $this->setUserAgent($_SERVER["HTTP_USER_AGENT"]);
        $this->setScheme($_SERVER["REQUEST_SCHEME"]);
        $this->setCookie($_COOKIE);

        $uri = explode("?", $_SERVER["REQUEST_URI"]);
        $this->setRequestURI($uri[0]);

        $uri = explode("/", $this->requestURI);
        $script = explode("/", $this->scriptName);

        for($i= 0;$i < sizeof($script);$i++){
            if ((isset($uri[$i])) && ($uri[$i] == $script[$i]))
                unset($uri[$i]);
        }

        $resource = array_values($uri);
        $this->setResource(empty($resource) ? "/" : $resource);
    }

    /**
     * @param mixed $resource
     */
    public function setResource($resource) {
        $this->resource = $resource;
    }

    /**
     * @return mixed
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * @param mixed $cookie
     */
    public function setCookie($cookie) {
        $this->cookie = $cookie;
    }

    /**
     * @return mixed
     */
    public function getCookie() {
        return $this->cookie;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host) {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * @param mixed $remoteIP
     */
    public function setRemoteIP($remoteIP) {
        $this->remoteIP = $remoteIP;
    }

    /**
     * @return mixed
     */
    public function getRemoteIP() {
        return $this->remoteIP;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query) {
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * @param mixed $requestTime
     */
    public function setRequestTime($requestTime) {
        $this->requestTime = $requestTime;
    }

    /**
     * @return mixed
     */
    public function getRequestTime() {
        return $this->requestTime;
    }

    /**
     * @param mixed $requestURI
     */
    public function setRequestURI($requestURI) {
        $this->requestURI = rtrim($requestURI, "/");
    }

    /**
     * @return mixed
     */
    public function getRequestURI() {
        return $this->requestURI;
    }

    /**
     * @param mixed $scheme
     */
    public function setScheme($scheme) {
        $this->scheme = $scheme;
    }

    /**
     * @return mixed
     */
    public function getScheme() {
        return $this->scheme;
    }

    /**
     * @param mixed $scriptName
     */
    public function setScriptName($scriptName) {
        $this->scriptName = rtrim($scriptName, "/");
    }

    /**
     * @return mixed
     */
    public function getScriptName() {
        return $this->scriptName;
    }

    /**
     * @param mixed $userAgent
     */
    public function setUserAgent($userAgent) {
        $this->userAgent = $userAgent;
    }

    /**
     * @return mixed
     */
    public function getUserAgent() {
        return $this->userAgent;
    }
}