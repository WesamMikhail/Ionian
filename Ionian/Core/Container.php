<?php
namespace Ionian\Core;

class Container {
    protected $registry = array();

    public function __set($key, $value){
        $this->registry[$key] = $value;
    }

    public function __get($key){
        return $this->registry[$key]();
    }
}