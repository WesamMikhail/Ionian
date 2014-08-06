<?php
namespace Libraries\Google;

class MapsAPI {

    private $base_url = "http://maps.google.com/maps/api/geocode/json?sensor=false";

    /**
     * Look up address coordinates (longtitute and latitude)
     * 
     * @param string $address
     * @return array/boolean Array on succes, False otherwise 
     */
    public function addressCoordinates($address) {
        $url = $this->base_url . "&address=" . urlencode($address);

        try {
            $json = json_decode(file_get_contents($url), true);

            if ($json["status"] == "OK") {
                return array("lng" => $json["results"][0]["geometry"]["location"]["lng"],
                    "lat" => $json["results"][0]["geometry"]["location"]["lat"]
                );
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Partial address lookup containing:
     *  country
     *  state
     *  city
     *  address
     *  zip
     * 
     * @param string $address
     * @return array/booleab Array on success, False otherwise 
     */
    public function partialAddressLookup($address) {
        $url = $this->base_url . "&address=" . urlencode($address);

        try {
            $json = json_decode(file_get_contents($url), true);
            if ($json["status"] == "OK") {

                $result = array("country" => "US");
                $result["coordinates"] = array();


                $address_components = $json["results"][0]["address_components"];

                $street_number = "";
                $route = "";
                $locality = "";
                $subpremise = "";

                foreach ($address_components as $key => $value) {

                    switch ($value["types"][0]) {
                        case "administrative_area_level_1":
                            $result["state"] = $value["short_name"];
                            break;

                        case "administrative_area_level_2":
                            $result["city"] = $value["long_name"];
                            break;

                        case "postal_code":
                            $result["zip"] = $value["long_name"];
                            break;

                        case "street_number":
                            $street_number = $value["long_name"];
                            break;

                        case "route":
                            $route = $value["long_name"];
                            break;

                        case "locality":
                            $locality = $value["long_name"];
                            break;

                        case "subpremise":
                            $subpremise = $value["short_name"];
                            break;
                    }
                }

                if (($street_number != "") && ($route != ""))
                    $result["address"] = $street_number . " " . $route . " #" . $subpremise . ", " . $locality;
                else
                    $result["address"] = null;

                $result["coordinates"] = array("lng" => $json["results"][0]["geometry"]["location"]["lng"],
                    "lat" => $json["results"][0]["geometry"]["location"]["lat"]
                );

                return $result;
            }
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Complete address lookup with all the information Google maps provice us with
     * 
     * @param string $address
     * @return array/boolean Array on success, False otherwise 
     */
    public function fullAddressLookup($address) {
        $url = $this->base_url . "&address=" . urlencode($address);

        try {
            $json = json_decode(file_get_contents($url), true);
            if ($json["status"] == "OK") {
                return $json;
            }
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }

}