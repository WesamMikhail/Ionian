<?php
namespace Ionian\Core;

use PDO;

abstract class Controller{
    protected $db;

    function __construct(PDO $db = null){
        $this->db = $db;
    }

    public static function outputJSON($response = "NO MSG PROVIDED!", $data = []){
        header('Content-Type: application/json');
        if(empty($data)) $data = false;
        print_r(json_encode(["code" => 200, "response" => $response, "data" => $data], JSON_PRETTY_PRINT));
    }
}