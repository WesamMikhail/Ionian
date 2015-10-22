<?php
namespace Lorenum\Ionian\Core;

use PDO;

/**
 * Class Model
 * This class is the base class for all models.
 * It contains references, getters and setters for all the necessary dependencies that a model might need.
 *
 * @package Lorenum\Ionian\Core
 */
abstract class Model{
    /**
     * @var PDO
     */
    protected $db;

    function __construct(PDO $db){
        $this->setDb($db);
    }

    /**
     * @return PDO
     */
    public function getDb() {
        return $this->db;
    }

    /**
     * @param PDO $db
     */
    public function setDb(PDO $db) {
        $this->db = $db;
    }

    public function getLastInsertID(){
        return $this->db->lastInsertId();
    }
}