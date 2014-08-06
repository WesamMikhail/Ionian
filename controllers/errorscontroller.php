<?php
namespace Controllers;
use Core\Controller as Controller;

class ErrorsController extends Controller{
    public function notfoundAction(){
        $this->renderAPI(404);
    }
}