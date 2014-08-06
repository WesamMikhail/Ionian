<?php
class ErrorsController extends Controller{
    public function notfoundAction(){
        $this->renderAPI(404);
    }
}