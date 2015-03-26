<?php
namespace Project\Controllers;

use Ionian\Core\Controller;

class TestController extends Controller{
    public function testAction(){
        echo "test empty!";
    }

    public function test2Action($required){
        echo "required $required";
    }

    public function test3Action($required, $optional = 'DEFAULT'){
        echo "test $required $optional";
    }

    public function test4Action($required, $required2){
        echo "test $required $required2";
    }

}