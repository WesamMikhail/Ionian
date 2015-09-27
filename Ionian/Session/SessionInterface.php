<?php

namespace Ionian\Session;

Interface SessionInterface{
    public function addRecord($key, $value);
    public function removeRecord($key);
    public function destroy();
}