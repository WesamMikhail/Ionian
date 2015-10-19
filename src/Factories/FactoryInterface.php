<?php
namespace Lorenum\Ionian\Factories;

Interface FactoryInterface{
    public function get($class, $action = null);
}