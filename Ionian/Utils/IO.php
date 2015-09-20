<?php
namespace Ionian\Utils;

Class IO {
    public static function getRemoteFileInfo($url, $returnObject = true){
        $headers = get_headers($url, true);

        if($returnObject)
            return (object) $headers;

        return $headers;

    }
}