<?php
namespace Project\Controllers;

use Ionian\Core\Controller;
use Ionian\Logging\Logger;

class TestController extends Controller{
    public function testAction($value){
        Logger::Log("Test data", "ERROR!");
    }
}