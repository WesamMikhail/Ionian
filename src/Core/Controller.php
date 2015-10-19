<?php
namespace Lorenum\Ionian\Core;

use Lorenum\Ionian\Request\Request;
use Lorenum\Ionian\Factories\ModelFactory;
use Lorenum\Ionian\Response\ResponseInterface;

/**
 * Class Controller
 * This class is the base class for all controllers.
 * It contains references, getters and setters for all necessary dependencies for a controller to run.
 *
 * @package Lorenum\Ionian\Core
 */
abstract class Controller{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var ModelFactory
     */
    protected $models;

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request) {
        $this->request = $request;
    }

    /**
     * @return ModelFactory
     */
    public function getModels() {
        return $this->models;
    }

    /**
     * @param ModelFactory $models
     */
    public function setModels(ModelFactory $models) {
        $this->models = $models;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response) {
        $this->response = $response;
    }
}