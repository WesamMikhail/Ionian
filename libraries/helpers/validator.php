<?php
class Helpers_Validator{
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

}

