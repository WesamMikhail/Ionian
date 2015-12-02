<?php
namespace Lorenum\Ionian\Core;

use Lorenum\Ionian\Errors\ApplicationExceptions\ArgumentException;
use Lorenum\Ionian\Errors\ApplicationExceptions\InstanceException;
use Lorenum\Utils\Explorer;

/**
 * Class Controller
 * This class is the base class for all controllers.
 *
 * @package Lorenum\Ionian\Core
 */
abstract class Controller{
    /**
     * @var AppSettings
     */
    protected $settings;

    function __construct(AppSettings $settings){
        $this->settings = $settings;
    }

    /**
     * @return AppSettings
     */
    public function getSettings() {
        return $this->settings;
    }

    /**
     * Get Query string field by key. same as $_GET
     *
     * @param $key
     * @return mixed|null
     */
    public function getQuery($key){
        return $this->getSettings()->getRequest()->query($key);
    }

    /**
     * Get request body field by key. Same as $_POST
     *
     * @param $key
     * @return mixed|null
     */
    public function getBody($key){
        return $this->getSettings()->getRequest()->body($key);
    }

    /**
     * Get header field by key.
     * @param $key
     * @return mixed|null
     */
    public function getHeader($key){
        return $this->getSettings()->getRequest()->header($key);
    }

    /**
     * Get the set DB connection
     *
     * @return \PDO
     */
    public function getDb(){
        return $this->getSettings()->getDb();
    }

    /**
     * Get Response object
     *
     * @return \Lorenum\Ionian\Response\ResponseInterface
     */
    public function getResponse(){
        return $this->getSettings()->getResponse();
    }

    /**
     * Get a model instance by its name
     *
     * @param $name
     * @return \Lorenum\Ionian\Core\Model subclass
     * @throws ArgumentException
     * @throws InstanceException
     */
    public function getModel($name){
        //DB must be set in the container in order to inject it into the model
        if(is_null($this->settings->getDb()))
            throw new ArgumentException("Cannot create a model unless a DB connection is set in the container");

        //Fully qualify the model name
        $class = $this->settings->getModelNamespace() . $name;

        //If the class does not exist in the filesystem
        if(!Explorer::checkIfClassExists($class))
            throw new InstanceException("The model '$class' could not be found in its namespace");

        //If the model does not extend the base model
        if(!is_subclass_of($class, "\\Lorenum\\Ionian\\Core\\Model"))
            throw new InstanceException("Class '$class' does not inherit from '\\Lorenum\\Ionian\\Core\\Model'");

        return new $class($this->settings->getDb());
    }
}