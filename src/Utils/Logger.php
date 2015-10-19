<?php
namespace Lorenum\Ionian\Utils;

/**
 * Class Logger
 * @package Lorenum\Ionian\Utils
 */
Class Logger{

    /**
     * Append a simple logging message at the end of a given file
     * @param $key
     * @param $msg
     * @param string $fileName
     */
    public static function Log($key, $msg, $fileName) {
        $dir = dirname($fileName);

        if(!is_readable($dir)){
            mkdir($dir, 0777, true);
        }

        file_put_contents($fileName, date('Y-m-d H:i:s') . " {$key} => {$msg} " . PHP_EOL, FILE_APPEND);
    }
}