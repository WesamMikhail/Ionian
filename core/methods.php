<?php

class Methods {

    /**
     * Check if value is between start and end
     *
     * @param int $value
     * @param int $start
     * @param int $end
     * @return boolean True if between, False if not!
     */
    public static function isBetween($value, $start, $end) {
        if ($value >= $start && $value <= $end)
            return true;
        return false;
    }


    /**
     * Check if value/values are not empty
     * This method uses func_get_args() so you can pass in as many variables/items as you want!
     *
     * @return boolean True if all value/values are not empty, false if one of the elements are empty
     */
    public static function isNotEmpty() {
        $args = func_get_args();

        foreach ($args as $item) {

            if (is_array($item)) {
                if (empty($item))
                    return false;
            }
            else {
                $item = trim($item);
                if (empty($item) && $item !== "0") //0 as string is allowed, a field can be zero as string
                    return false;
            }
        }

        return true;
    }

    /**
     * Check if email is valid!
     *
     * @param string $value
     * @return boolean True if valid, false if not
     */
    public static function isValidEmail($value) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL))
            return true;
        return false;
    }

    /**
     * Generate a random string with repeatable letters.
     *
     * @param int $length Length of desired random string
     * @return string Random string
     */
    public static function generateRandomAlphaNumericString($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);

        $randomChars = array();
        for ($i = 0; $i < $length; $i++) {
            $randomChars[] = $chars[mt_rand(0, $size - 1)];
        }

        return implode('', $randomChars);
    }

    /**
     * Bcrypt Blowfish hasing using crypt (PHP 5.3+)
     *
     * @param string $string String to hash
     * @param int $cost Cost should be between 4 and 31. If not, Cost will be assigned to 8
     * @return type
     */
    public static function generateBcryptHash($string, $cost) {
        if ($cost < 4 || $cost > 31 || !is_numeric($cost)) {
            $cost = '08';
        }
        else {
            if (strlen($cost) == 1)
                $cost = '0' . $cost;
        }

        //$2a$ means Blowfish, $cost is set to modify encryption duration and randon string for salt
        $salt = '$2a$' . $cost . '$' . self::generateRandomAlphaNumericString(22);
        return crypt($string, $salt);
    }

    /**
     * Strip slashes for arrays!
     *
     * @param mixed /array $value
     * @return mixed/array stripped!
     */
    public static function stripslashes_deep($value) {
        $value = is_array($value) ? array_map('Methods::stripslashes_deep', $value) : stripslashes($value);

        return $value;
    }

    /**
     * Checks if ALL the values in $array1 exists in $array2
     *
     * @param $array1
     * @param $array2
     * @return true if all values exist, else false
     */
    public static function fullArrayIntersect($array1, $array2) {
        if (count(array_intersect($array1, $array2)) == count($array1))
            return true;

        else return false;
    }

    /**
     * Check if String is an integer value
     *
     * @param $string
     * @return true if integer, false otherwise
     */
    public static function is_integer($string) {
        if (((string)(int)$string == $string))
            return true;
        return false;
    }
}