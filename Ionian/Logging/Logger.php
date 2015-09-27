<?php
namespace Ionian\Logging;

Class Logger{
    public static function Log($key, $msg, $fileName = "/Project/Logs/main.log") {
        $fileName = ROOT . $fileName;
        $dir = dirname($fileName);

        if(!is_readable($dir)){
            mkdir($dir, 0777, true);
        }

        file_put_contents($fileName, date('Y-m-d H:i:s') . " {$key} => {$msg} " . PHP_EOL, FILE_APPEND);
    }
}