<?php
namespace Lorenum\Ionian\Factories;

use Lorenum\Ionian\Utils\Explorer;

/**
 * Class Factory
 * Base factory class that can be used to instantiate any object
 *
 * @package Lorenum\Ionian\Factories
 */
class Factory implements FactoryInterface{
    protected $namespace;

    /**
     * @param string $namespace default namespace will be enforced to \Project\
     */
    function __construct($namespace = '\\Project\\') {
        $this->setNamespace($namespace);
    }

    /**
     * @return string
     */
    public function getNamespace() {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace) {
        $this->namespace = $namespace;
    }

    /**
     * instantiate the class in case it exists.
     * Action is an optional parameter where the class wont be instanciated unless the action exists as well
     *
     * @param $class
     * @param $action
     * @return mixed|false False if class/method was not found
     */
    public function get($class, $action = null){
        $class = $this->getNamespace() . $class;

        if(is_null($action) && Explorer::classExists($class))
            return new $class;

        else if(Explorer::classMethodExists($class, $action))
            return new $class;

        return false;
    }
}