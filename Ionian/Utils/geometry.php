<?php
namespace Ionian\Utils;

class Geometry {

    /**
     * Method for determining in case a point is within a long/lat polygon
     * Ex:
     * $polygon = array(array("lng" => 37.628134, "lat" => -77.458334), array("lng" =>37.629867, "lat" => -77.449021), array("lng" =>37.62324, "lat" => -77.445416), array("lng" =>37.622424, "lat" => -77.457819));
     * $coordsInside = array("lng" => 37.62850, "lat" => -77.4499);
     * 
     * @param array $polygon        Array containing polygon points
     * @param array $point          Array of lng, lat
     * @return boolean True if intersects, False otherwise 
     */
    public static function pointInPolygon($polygon, $point) {
        $numVertices = count($polygon);
        $verticesX = array();
        $verticesY = array();
        $pointX = $point["lng"];
        $pointY = $point["lat"];

        foreach ($polygon as $point) {
            $verticesX[] = $point["lng"];
            $verticesY[] = $point["lat"];
        }
       
        $i = $j = $c = 0;

        for ($i = 0, $j = $numVertices - 1; $i < $numVertices; $j = $i++) {
            if ((($verticesY[$i] > $pointY != ($verticesY[$j] > $pointY)) &&
                    ($pointX < ($verticesX[$j] - $verticesX[$i]) * ($pointY - $verticesY[$i]) / ($verticesY[$j] - $verticesY[$i]) + $verticesX[$i])))
                $c = !$c;
        }

        return $c;
    }

}