<?php

namespace Ionian\Session;

class FileSessionManager implements SessionInterface {

    public function start() {
        if (!headers_sent() && session_start()) {
            return true;
        }
        return false;
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