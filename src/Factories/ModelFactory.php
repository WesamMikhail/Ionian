<?php
namespace Lorenum\Ionian\Factories;

use PDO;

/**
 * Class ModelFactory
 * This class is responsible for creating a model and injecting all of its dependencies
 *
 * @package Lorenum\Ionian\Factories
 */
class ModelFactory extends Factory{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * @param string $namespace the namespace will be defaulted to \Project\Models unless you specify otherwise
     */
    function __construct($namespace = '\\Project\\Models\\') {
        parent::__construct($namespace);
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


    /**
     * Get an instance of the desired class if it exists.
     * Action is an optional parameter that returns a class instance if both the class AND the action exists within
     *
     * @param $class
     * @param null $action
     * @return false|mixed False if the class is not found or is not a subclass of Lorenum\Ionian\Core\Model
     */
    public function get($class, $action = null){
        $model = parent::get($class, $action);
        if($model !== false){
            if(!is_subclass_of($model, "\\Lorenum\\Ionian\\Core\\Model"))
                return false;

            $model->setDb($this->getDb());
        }

        return $model;
    }
}