<?php
namespace RainCaptcha;

/**
 * RainCaptcha PHP Wrapper v1.1.0
 * Documentation: http://raincaptcha.driversworld.us/pages/docs_php_wrapper
 * This code is in the public domain.
 */
class RainCaptcha {
    const HOST = 'http://raincaptcha.driversworld.us/api/v1';

    private $sessionId;

    public function __construct($sessionId = null) {
        if($sessionId === null)
            $this->sessionId = md5($_SERVER['SERVER_NAME'] . ':' . $_SERVER['REMOTE_ADDR']);
        else
            $this->sessionId = $sessionId;
    }

    public function getImage() {
        return self::HOST . '/image/' . $this->sessionId . '?rand' . rand(100000, 999999);
    }

    public function checkAnswer($answer) {
        if(empty($answer))
            return false;
        $response = @file_get_contents(self::HOST . '/check/' . $this->sessionId. '/' . $answer);
        if($response === false)
            return true;
        return $response === 'true';
    }
}