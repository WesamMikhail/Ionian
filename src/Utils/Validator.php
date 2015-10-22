<?php
namespace Lorenum\Ionian\Utils;

/**
 * Class Validator
 * Validation helper functions
 *
 * @package Lorenum\Ionian\Utils
 */
class Validator{
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
     * Check if value/values are not empty
     * This method uses func_get_args() so you can pass in as many variables/items as you want!
     *
     * @return boolean True if all value/values are not empty, false if one of the elements are empty
     */
    public static function isNotEmpty() {
        $args = func_get_args();

        foreach ($args as $item) {

            if (is_array($item) && empty($item)) {
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
     * Check if string starts with substring
     *
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function startsWith($haystack, $needle){
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * Check if string ends with substring
     *
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function endsWith($haystack, $needle){
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}

