<?php
namespace Libraries\Amazon;

/**
 * AWS E-COMMERCE SERVICE!
 * AWSECommerceService
 * 
 * This class is a wrapper class that will take care of creating the correct 
 * Amazon request and parsing it using XML. 
 * 
 * usage:
 * Create amazon class isntance
 * $aws = new AmazonAWS($AWS_PUBLIC_KEY, $AWS_PRIVATE_KEY, "com");
 *
 * Create the required signed request
 * $request = $aws->aws_signed_request(array("Operation" => "ItemSearch", "Keywords" => $this->post["phrase"], "SearchIndex" => "All", "ResponseGroup" => "Images,ItemAttributes", "AssociateTag" => $associateTag));
 *
 * Get XML and output it
 * $xml = json_decode(json_encode(@simplexml_load_file($request)));
 */

class ECS {

    private $publicKey;
    private $privateKey;
    private $region;

    public function __construct($publicKey, $privateKey, $region) {
        $this->setPublicKey($publicKey);
        $this->setPrivateKey($privateKey);
        $this->setRegion($region);
    }

    public function getPublicKey() {
        return $this->publicKey;
    }

    public function setPublicKey($publicKey) {
        $this->publicKey = $publicKey;
    }

    public function getPrivateKey() {
        return $this->privateKey;
    }

    public function setPrivateKey($privateKey) {
        $this->privateKey = $privateKey;
    }

    public function getRegion() {
        return $this->region;
    }

    public function setRegion($region) {
        $this->region = $region;
    }

    /**
     * Amazon signed request handler
     * 
     * @param string $region the Amazon(r) region (ca,com,co.uk,de,fr,jp)
     * @param array $params an array of parameters, eg. array("Operation"=>"ItemLookup","ItemId"=>"B000X9FLKM", "ResponseGroup"=>"Small")
     * @return boolean/xml False on error, XML on success
     */
    public function aws_signed_request($params) {

        //Request paramesters
        $method = "GET";
        $host = "ecs.amazonaws." . $this->region;
        $uri = "/onca/xml";

        //Shared request parameters
        $params["Service"] = "AWSECommerceService";
        $params["AWSAccessKeyId"] = $this->publicKey;
        $params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z");
        $params["Version"] = "2009-03-31";

        ksort($params);

        // create the canonicalized query
        $canonicalized_query = array();
        foreach ($params as $param => $value) {
            $param = str_replace("%7E", "~", rawurlencode($param));
            $value = str_replace("%7E", "~", rawurlencode($value));
            $canonicalized_query[] = $param . "=" . $value;
        }
        $canonicalized_query = implode("&", $canonicalized_query);

        // create the string to sign
        $string_to_sign = $method . "\n" . $host . "\n" . $uri . "\n" . $canonicalized_query;

        // calculate HMAC with SHA256 and base64-encoding
        // encode the signature for the request
        $signature = str_replace("%7E", "~", rawurlencode(base64_encode(hash_hmac("sha256", $string_to_sign, $this->privateKey, True))));

        //return complete requst string
        return "http://" . $host . $uri . "?" . $canonicalized_query . "&Signature=" . $signature;
    }

}