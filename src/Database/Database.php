<?php
namespace Lorenum\Ionian\Database;

use PDO;
use Exception;

/**
 * Class Database
 * This Class wraps the creation process of PDO instances so that the user does not have to enter all the default
 * settings every time. In addition, this class can create a PDO handler from given settings files
 *
 * @package Lorenum\Ionian\Database
 */
Class Database{

    /**
     * Creates a PDO database connection rom given credentials
     *
     * @param $driver
     * @param $host
     * @param $db
     * @param $user
     * @param $password
     * @param array $options
     * @return PDO
     */
    public static function create($driver, $host, $db, $user, $password, array $options = []){
        $db = new PDO("$driver:dbname=$db;host=$host", $user, $password);
        
        if(!isset($options[PDO::ATTR_DEFAULT_FETCH_MODE]))
            $options[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_ASSOC;

        if(!isset($options[PDO::ATTR_EMULATE_PREPARES]))
            $options[PDO::ATTR_EMULATE_PREPARES] = false;

        foreach($options as $key => $val){
            $db->setAttribute($key, $val);
        }

        return $db;
    }

    /**
     * Creates a database connection using the Database::create method. However, this method reads the DB connection
     * settings from a JSON file located in $filename
     *
     * @param $filename
     * @param array $options
     * @return PDO
     * @throws Exception
     */
    public static function createFromJSONFile($filename, array $options = []){
        $file = file_get_contents($filename);
        $settings = json_decode($file, true);

        if(!isset($settings["database"]))
            throw new Exception("Database credentials are missing");

        if(!isset($settings["database"]["driver"]))
            throw new Exception("Database driver credential is missing");

        if(!isset($settings["database"]["host"]))
            throw new Exception("Database host credential is missing");

        if(!isset($settings["database"]["db"]))
            throw new Exception("Database db credential is missing");

        if(!isset($settings["database"]["user"]))
            throw new Exception("Database user credential is missing");

        if(!isset($settings["database"]["password"]))
            throw new Exception("Database password credential is missing");

        return Database::create(
            $settings["database"]["driver"],
            $settings["database"]["host"],
            $settings["database"]["db"],
            $settings["database"]["user"],
            $settings["database"]["password"],
            $options
        );
    }
}