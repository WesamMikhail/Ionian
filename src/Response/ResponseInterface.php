<?php
namespace Lorenum\Ionian\Response;

Interface ResponseInterface{
    public function output();
    public function setProtocol($protocol);
    public function getProtocol();
    public function setMessage($message);
    public function getMessage();
    public function setCode($code);
    public function getCode();
    public function setStatus($status);
    public function getStatus();
    public function setData($data);
    public function getData();
}