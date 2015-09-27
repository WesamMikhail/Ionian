<?php
namespace Ionian\Utils;

use SimpleXMLElement;

Class XML {
    /**
     * Covert a regular PHP array into an XML node
     *
     * @param mixed $array array to be converted
     * @param SimpleXMLElement $xmlNode root node that the xml tree will be attached to
     */
    public static function array2xml($array, SimpleXMLElement &$xmlNode) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xmlNode->addChild("$key");
                    XML::array2xml($value, $subnode);
                }
                else {
                    $subnode = $xmlNode->addChild("item$key");
                    XML::array2xml($value, $subnode);
                }
            }

            else if (is_numeric($key))
                $xmlNode->addChild("item$key", htmlspecialchars("$value"));

            else
                $xmlNode->addChild("$key", htmlspecialchars("$value"));
        }
    }
}