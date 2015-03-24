<?php
namespace Ionian\Utils;

use Exception;

class Encryption{
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
     * Blowfish hasing using crypt (PHP 5.3.7+)
     *
     * @param string $string String to hash
     * @param int $cost Cost should be between 4 and 31. If not, Cost will be assigned to 9
     * @throws Exception if Crypt is not installed!
     * @return String
     */
    public static function generateBlowfishHash($string, $cost) {
        if (!function_exists('crypt')) {
            trigger_error('Cannot find Crypt extension!', E_USER_ERROR);
        }

        if ($cost < 4 || $cost > 31 || !is_numeric($cost)) {
            $cost = '09';
        }

        if (strlen($cost) == 1){
            $cost = '0' . $cost;
        }

        //$2a$ means Blowfish, $cost is set to modify encryption duration and randon string for salt
        $salt = '$2y$' . $cost . '$' . self::generateRandomAlphaNumericString(22);
        return crypt($string, $salt);
    }
}