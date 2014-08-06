<?php
abstract class Controller {
    protected $responseHandler;
    protected $params;

    function __construct($params, $responseHandler){
        $this->params = $params;
        $this->responseHandler = $responseHandler;
    }

    public function renderAPI($code, $data = null){
        $this->responseHandler->renderAPI($code, $data);
    }

    public function renderView($view, $data = null){
        $this->responseHandler->renderView($view, $data);
    }

}