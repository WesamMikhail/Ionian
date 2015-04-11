<?php

namespace Ionian\Session;

Interface SessionInterface{
    public function start();
    public function addRecord($key, $value);
    public function removeRecord($key);
    public function destroy();
}