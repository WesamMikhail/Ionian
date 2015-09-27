<?php
namespace Ionian\Core;

abstract class Controller{
    public static function outputJSON($response = "NO MSG PROVIDED!", $data = []){
        header('Content-Type: application/json');
        if(empty($data)) $data = false;
        print_r(json_encode(["code" => 200, "response" => $response, "data" => $data], JSON_PRETTY_PRINT));
    }
}