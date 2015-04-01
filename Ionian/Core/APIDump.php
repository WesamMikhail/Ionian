<?php
namespace Ionian\Core;

class APIDump{
    public static function output($code, $response = "NO MSG PROVIDED!", $data = null){
        header('Content-Type: application/json');
        $dump = ["code" => $code, "response" => $response];
        if(!is_null($data))
            $dump["data"] = $data;

        print_r(json_encode($dump, JSON_PRETTY_PRINT));
    }
}