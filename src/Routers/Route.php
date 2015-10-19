<?php
namespace Lorenum\Ionian\Routers;

/**
 * Class Route
 * Route is a simple container class that has all the information about the desired route
 *
 * @package Lorenum\Ionian\Routers
 */
class Route{
    protected $controller;
    protected $action;
    protected $params = [];

    /**
     * @return string
     */
    public function getController() {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController($controller) {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action) {
        $this->action = $action;
    }

    /**
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams($params) {
        $this->params = $params;
    }


}