<?php
namespace Lorenum\Ionian\Response;

/**
 * Class Response
 * Response is a simple abstract information container that the implementing class will know how to output.
 * This abstract class implements the interface so that the concrete class must do so as well.
 *
 * @package Lorenum\Ionian\Response
 */
abstract class Response implements ResponseInterface{
    protected $protocol;
    protected $code;
    protected $status;
    protected $message;

    /**
     * @var mixed $data is the DATA returned to the user. Null is not handled properly by all JS/Mobile clients but false is.
     */
    protected $data = false;

    /**
     * @return mixed
     */
    public function getProtocol() {
        return $this->protocol;
    }

    /**
     * @param mixed $protocol
     */
    public function setProtocol($protocol) {
        $this->protocol = $protocol;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code) {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }
}