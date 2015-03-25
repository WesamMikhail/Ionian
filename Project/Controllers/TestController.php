<?php
namespace Project\Controllers;

use Ionian\Core\Controller;

class TestController extends Controller{
    public function testAction(){
        echo "test empty!";
    }

    public function test2Action($required){
        echo "test required1";
    }

    public function test3Action($required, $optional = ''){
        echo "test required1 optional1";
    }

    public function test4Action($required, $required2){
        echo "test required required";
    }

}