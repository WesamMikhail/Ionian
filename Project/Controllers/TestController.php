<?php
namespace Project\Controllers;

use Ionian\Core\Controller;

class TestController extends Controller{
    public function testAction(){
        echo "you are in!";
        var_dump($this->app->getDB());
    }
}