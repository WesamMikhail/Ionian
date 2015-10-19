<?php
namespace Lorenum\Ionian\Response;

/**
 * Class JSONResponse
 * JSONResponse is responsible for formatting and displaying the output in JSON.
 *
 * @package Lorenum\Ionian\Response
 */
class JSONResponse extends Response{

    /**
     * Outputs the Response object back in JSON format.
     * If no HTTP status code is set, it will default back to 200 OK
     */
    public function output() {
        //Default request code is 200 if nothing else is given
        if(is_null($this->getCode())) {
            $this->setCode(200);
            $this->setStatus("OK");
        }

        //Compile the data into a list that will be sent to the client
        $result = [
            "protocol"  => $this->getProtocol(),
            "code"      => $this->getCode()
        ];

        //Status and message are not included in case they are null. That means the developer chose to not show them.
        if(!is_null($this->getStatus()))
            $result["status"] = $this->getStatus();

        if(!is_null($this->getMessage()))
            $result["message"] = $this->getMessage();

        //data is set to false by default unless overwritten. This is because not all clients handle NULL the same way.
        $result["data"] = $this->getData();

        //Set the headers accordingly
        header($this->getProtocol() . " " . $this->getCode() . " " . $this->getStatus());
        header('Content-Type: application/json');

        //Encode as JSON
        $json = json_encode($result, JSON_PRETTY_PRINT);

        //Output
        print_r($json);
    }
}