<?php
namespace Core;
use PDO;

//TODO Expand Class
class PDOExtension extends PDO{
    function __construct($driver, $host, $db, $user, $password, $options = null){
        parent::__construct($driver . ":host=" . $host . ";dbname=" . $db, $user, $password, $options);
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING);
    }
}