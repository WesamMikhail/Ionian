<?php

class JSON {
    
    /**
     * Convert an array into readable JSON
     * 
     * @param mixed $array
     * @return JSON 
     */
    public static function arrayToReadableJSON($array){
        return self::jsonStringToReadable(json_encode($array));
    }

    /**
     * Convert JSON string to a human readable array!
     * 
     * @param array $json json_encode array
     * @return string output 
     */
    public static function jsonStringToReadable($json) {
        $tc = 0;        //tab count
        $r = '';        //result
        $q = false;     //quotes
        $t = "\t";      //tab
        $nl = "\n";     //new line

        for ($i = 0; $i < strlen($json); $i++) {
            $c = $json[$i];
            if ($c == '"' && $json[$i - 1] != '\\')
                $q = !$q;
            if ($q) {
                $r .= $c;
                continue;
            }
            switch ($c) {
                case '{':
                case '[':
                    $r .= $c . $nl . str_repeat($t, ++$tc);
                    break;
                case '}':
                case ']':
                    $r .= $nl . str_repeat($t, --$tc) . $c;
                    break;
                case ',':
                    $r .= $c;
                    if ($json[$i + 1] != '{' && $json[$i + 1] != '[')
                        $r .= $nl . str_repeat($t, $tc);
                    break;
                case ':':
                    $r .= $c . ' ';
                    break;
                default:
                    $r .= $c;
            }
        }
        return $r;
    }

}
