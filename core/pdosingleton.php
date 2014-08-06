<?php

/**
 * PDO Singleton class
 * 
 * Use PDOSingleton::getInstance() to get the PDO instance  
 */
abstract class PDOSingleton {

    private static $_INSTANCE;

    private function __construct() {}

    private function __clone() {}

    /**
     * Creates the PDO instance with the settings from the Configs file.
     * PDO::ATTR_DEFAULT_FETCH_MODE is set to PDO::FETCH_ASSOC
     * 
     * @return PDO Instance of PDO 
     */
    public static function getInstance() {
        if (!self::$_INSTANCE) {
            self::$_INSTANCE = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB, MYSQL_USER, MYSQL_PASSWORD);
            self::$_INSTANCE->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$_INSTANCE->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING);
        }

        return self::$_INSTANCE;
    }

}

