<?php
namespace Ionian\Logging;

Interface FileLoggerInterface{
    public static function Log($key, $msg, $fileName = null);
}