<?php
$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1');
header($protocol . " 404 Not Found");
header('Content-Type: application/json');
print_r(json_encode(["code" => 404, "status" => "Not Found.", "message" => "The requested resource was not found."], JSON_PRETTY_PRINT));