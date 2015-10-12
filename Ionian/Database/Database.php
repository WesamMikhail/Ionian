<?php
namespace Ionian\Database;

use PDO;
use Exception;
use Ionian\Utils\Explorer;

Class Database{
    /**
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

        if(!empty($options)){
            foreach($options as $key => $val){
                $db->setAttribute($key, $val);
            }
        }

        return $db;
    }

    /**
     * @param $file
     * @param array $options
     * @return PDO
     * @throws Exception
     */
    public static function createFromINI($file, $options = []){
        if(Explorer::getFileExtension($file) != "ini")
            throw new Exception("Settings file is not of extension 'ini'.");

        $settings = parse_ini_file($file, true);

        if(!isset($settings["Database"]))
            throw new Exception("[Database] section is not found in $file");

        $db = $settings["Database"];

        if(!isset($db["db"], $db["host"], $db["database"], $db["user"], $db["password"]))
            throw new Exception("The following keys are required 'db, host, database, user, password' under the [Database] section.");

        return self::create($db["db"], $db["host"], $db["database"], $db["user"], $db["password"], $options);
    }

}