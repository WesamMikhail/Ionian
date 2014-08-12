<?php
namespace Core;

abstract class Controller {
    protected $responseHandler;
    protected $db;

    function __construct($responseHandler) {
        $this->responseHandler = $responseHandler;
    }

    /**
     * Set DB connector.
     *
     * @param $db
     */
    public function setDB($db) {
        $this->db = $db;
    }

    /**
     * Render response as an API by dumping data to the screen
     *
     * @param string/int $code Code is the status code to be sent to the client
     * @param null $data Data to be dumped
     */
    public function renderAPI($code, $data = null) {
        $this->responseHandler->renderAPI($code, $data);
    }

    /**
     * Render response from a template/view
     *
     * @param string $view filename
     * @param null $data Data to be displayed
     */
    public function renderView($view, $data = null) {
        $this->responseHandler->renderView($view, $data);
    }
}