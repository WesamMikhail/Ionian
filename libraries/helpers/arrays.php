<?php
class Helpers_Arrays{

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
}