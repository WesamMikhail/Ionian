<?php

namespace Ionian\Session;

class FileSessionManager implements SessionInterface {

    protected static $instance = null;

    private function __construct(){}

    private function __clone(){}

    /**
     * @return FileSessionManager|null Null is returned in case sessions are disabled according to PHP_SESSION_DISABLED constant
     */
    public static function getInstance(){
        if (!isset(self::$instance)) {
            $sm = new FileSessionManager;
            if($sm->start())
                self::$instance = $sm;
        }

        return self::$instance;
    }

    private function start() {
        if(session_status() == PHP_SESSION_DISABLED)
            return false;

        else if (session_status() == PHP_SESSION_NONE) {
            return session_start();
        }

        return true;
    }

    public function getSession() {
        return (object)$_SESSION;
    }

    public function getRecord($key) {
        return $_SESSION[$key];
    }

    public function addRecord($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function removeRecord($key) {
        unset($_SESSION[$key]);
    }

    public function destroy() {
        session_unset();
        session_destroy();
    }
}