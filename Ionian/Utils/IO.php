<?php
namespace Ionian\Utils;

Class IO {
    /**
     * Returns a remote URL information by getting the headers
     *
     * @param $url
     * @param bool $returnObject Default = false. Set to true if you want an STD-class returned
     * @return array|object
     */
    public static function getRemoteFileInfo($url, $returnObject = false){
        $headers = get_headers($url, true);

        if($returnObject)
            return (object) $headers;

        return $headers;

    }
}