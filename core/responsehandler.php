<?php
Class ResponseHandler{

    private $code = 200;
    private $content = null;
    private $_CODES = array(
        "200" => "Success!",
        "401" => "Unauthorized Resource / Incorrect Password!",
        "403" => "Authentication Required!",
        "404" => "Invalid Request or Resource!"
    );

    /**
     * Sets the array of error codes that the application can use
     *
     * @param array $codes
     */
    public function setResponseCodes($codes) {
        $this->_CODES = $codes;
    }

    /**
     * Merges the current array of error codes with the provided one in order to extend it!
     *
     * @param array $codes
     */
    public function addResponseCodes($codes){
        $this->_CODES = array_merge($this->_CODES, $codes);
    }

    /**
     * Render the response through a view (template)
     *
     * @param String $template filename
     * @param mixed $data  data to be presented
     */
    public function renderView($template, $data){
        $view = new View();
        $view->setData($data);
        $view->render($template);
    }

    /**
     * Render the response output via data dumping
     * The responseType (JSON/XML/JSONP) depends on the $_GET["responseType"] parameter
     *
     * @param int/string $code status code
     * @param mixed $data data to present
     */
    public function renderAPI($code, $data){
        $this->code = $code;
        $this->content = $data;

        if(isset($_GET["responsetype"]))
            $responseType = $_GET["responsetype"];
        else
            $responseType = "json";

        if($responseType == "xml"){
            header('Content-Type: application/xml; charset=utf-8');
            $this->XML();
        }

        else if($responseType == "json"){
            header('Content-Type: application/json');
            $this->JSON();
        }

        else if(($responseType == "jsonp") && (!empty($_GET["callback"]))){
            header('Content-Type: application/javascript');
            $this->JSONP($_GET["callback"]);
        }

        else{
            header('Content-Type: application/json');
            $this->JSON();
        }
    }

    private function JSON(){
        $output = array();

        $output["code"] = $this->code;
        $output["type"] = "json";
        $output["message"] = $this->_CODES[$this->code];

        if($this->content !== null)
            $output["response"] = $this->content;

        print_r(json_encode($output, JSON_PRETTY_PRINT));
    }

    private function JSONP($callback){
        $output = array();

        $output["code"] = $this->code;
        $output["type"] = "jsonp";
        $output["message"] = $this->_CODES[$this->code];

        if($this->content != null)
            $output["response"] = $this->content;


        print_r($callback . "( " . json_encode($output, JSON_PRETTY_PRINT) . " )");
    }

    private function XML(){
        $xml = new SimpleXMLElement("<data/>");

        $xml->addChild("code", $this->code);
        $xml->addChild("type", "xml");
        $xml->addChild("message", $this->_CODES[$this->code]);

        if($this->content != null){
            if(is_array($this->content))
                XML::array2xml($this->content, $xml->addChild("response"));
            else
                $xml->addChild("response",$this->content);
        }

        print $xml->asXML();
    }
}