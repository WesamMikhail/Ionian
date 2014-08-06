<?php
namespace Core;

abstract class Controller {
    protected $responseHandler;
    protected $params;
    protected $db;

    function __construct($params, $responseHandler, $db = null){
        $this->params = $params;
        $this->responseHandler = $responseHandler;
        $this->db = $db;
    }

    public function renderAPI($code, $data = null){
        $this->responseHandler->renderAPI($code, $data);
    }

    public function renderView($view, $data = null){
        $this->responseHandler->renderView($view, $data);
    }

}