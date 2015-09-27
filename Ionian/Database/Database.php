<?php
/**
 * This class Implements The Multiton Design Pattern (http://en.wikipedia.org/wiki/Multiton_pattern)
 */
namespace Ionian\Database;

use PDO;

Class Database Extends PDO{
    protected static $instances = array();

    public static function get($id = "DEFAULT", array $settings = null){
        if(isset(self::$instances[$id]))
            return self::$instances[$id];

        return self::create($id, $settings);
    }

    public static function create($id, array $settings){
        if((count($settings) == 5) || ($settings[5] === null))
            $settings[5] = array(); //If no options given, we pass empty options array at object creation below!

        $instance = new Database($settings[0] .":host=". $settings[1] . ";dbname=" . $settings[2] . ";charset=utf8", $settings[3], $settings[4], $settings[5]);
        self::$instances[$id] = $instance;

        return $instance;
    }
}