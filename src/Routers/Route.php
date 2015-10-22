<?php
namespace Lorenum\Ionian\Routers;

/**
 * Class Route
 * Route is a simple container class that has all the information about the desired route
 *
 * @package Lorenum\Ionian\Routers
 */
class Route{
    protected $controllerName = '';
    protected $actionName = '';
    protected $params = [];

    /**
     * @return string
     */
    public function getControllerName() {
        return $this->controllerName;
    }

    /**
     * @param string $controllerName
     */
    public function setControllerName($controllerName) {
        $this->controllerName = $controllerName;
    }

    /**
     * @return string
     */
    public function getActionName() {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     */
    public function setActionName($actionName) {
        $this->actionName = $actionName;
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