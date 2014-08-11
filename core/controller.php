<?php
namespace Core;

abstract class Controller {
    protected $responseHandler;
    protected $db;

    function __construct($responseHandler){
        $this->responseHandler = $responseHandler;
    }

    public function setDB($db){
        $this->db = $db;
    }

    public function renderAPI($code, $data = null){
        $this->responseHandler->renderAPI($code, $data);
    }

    public function renderView($view, $data = null){
        $this->responseHandler->renderView($view, $data);
    }

}