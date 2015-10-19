<?php
namespace Lorenum\Ionian\Utils;

/**
 * Class SimpleContainer
 * A simple container class that uses magic methods
 *
 * @package Lorenum\Ionian\Utils
 */
class SimpleContainer {
    protected $registry = array();

    public function __set($key, $value){
        $this->registry[$key] = $value;
    }

    public function __get($key){
        return $this->registry[$key];
    }
}