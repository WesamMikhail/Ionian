<?php
namespace Lorenum\Ionian\Request;

/**
 * Class Request
 * This class substitutes the need for using the super-globals such as $_SERVER, $_GET, $_POST, etc.
 * All the information you might need from the super globals can be found in this object including URI parsing.
 *
 * @package Lorenum\Ionian\Request
 */
class Request{
    protected $method;
    protected $protocol;
    protected $domain;
    protected $uri;
    protected $script;
    protected $ip;
    protected $query = [];
    protected $body = [];
    protected $headers = [];

    /**
     * Return the requested resource according to the request's URI.
     * The requested resource is an array of fragments.
     *
     * If empty, it means that the request was sent to the ROOT.
     *
     * @return array|bool return false if a resource fragment is an empty string
     */
    public function getRequestedResource(){
        $uri = explode("?", $this->getUri());

        $uri = explode("/", rtrim($uri[0], "/"));
        $script = explode("/", $this->getScript());

        for($i= 0;$i < sizeof($script);$i++){
            if ((isset($uri[$i])) && (strtolower($uri[$i]) == strtolower($script[$i])))
                unset($uri[$i]);
        }

        $resource = array_values($uri);
        foreach($resource as $resourceItem){
            if($resourceItem == ""){
                return false;
            }
        }
        return $resource;
    }

    /**
     * Get a single query string value by its key
     *
     * @param $key
     * @return mixed|null null on failure to find or if the key itself has null value
     */
    public function query($key){
        if(isset($this->query[$key]))
            return $this->query[$key];

        return null;
    }

    /**
     * Get a single body content value by its key
     *
     * @param $key
     * @return mixed|null null on failure to find or if the key itself has null value
     */
    public function body($key){
        if(isset($this->body[$key]))
            return $this->body[$key];

        return null;
    }

    /**
     * Get a single header value by its key
     *
     * @param $key
     * @return mixed|null null on failure to find or if the key itself has null value
     */
    public function header($key){
        if(isset($this->headers[$key]))
            return $this->headers[$key];

        return null;
    }

    /**
     * @return mixed
     */
    public function getMethod() {
        return $this->method;
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
    public function getProtocol() {
        return $this->protocol;
    }

    /**
     * @param mixed $protocol
     */
    public function setProtocol($protocol) {
        $this->protocol = $protocol;
    }

    /**
     * @return mixed
     */
    public function getDomain() {
        return $this->domain;
    }

    /**
     * @param mixed $domain
     */
    public function setDomain($domain) {
        $this->domain = $domain;
    }

    /**
     * @return mixed
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri) {
        $this->uri = $uri;
    }

    /**
     * @return mixed
     */
    public function getScript() {
        return $this->script;
    }

    /**
     * @param mixed $script
     */
    public function setScript($script) {
        $this->script = $script;
    }

    /**
     * @return mixed
     */
    public function getIp() {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip) {
        $this->ip = $ip;
    }

    /**
     * @return array
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * @param array $query
     */
    public function setQuery($query) {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param array $body
     */
    public function setBody($body) {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers) {
        $this->headers = $headers;
    }
}