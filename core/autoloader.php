<?php

/**
 * PHP autoloading class for Lorenum's Simple Framework
 *
 * This autoloading class i meant to be used with spl_autoload_register\
 * Ex.
 *  spl_autoload_register('AutoLoader::classLoader');
 *  spl_autoload_register('AutoLoader::controllerLoader');
 */
class AutoLoader {

    public static function coreLoader($class) {
        $class = $class . ".php";
        $classLower = strtolower($class);

        if (is_readable(ROOT . "/core/" . $class))
            require_once ROOT . "/core/" . $class;

        else if (is_readable(ROOT . "/core/" . $classLower))
            require_once ROOT . "/core/" . $classLower;
    }

    public static function controllerLoader($controller) {
        $controller = $controller . ".php";
        $controllerLower = strtolower($controller);

        if (is_readable(ROOT . "/controllers/" . $controller))
            require_once ROOT . "/controllers/" . $controller;

        else if (is_readable(ROOT . "/controllers/" . $controllerLower))
            require_once ROOT . "/controllers/" . $controllerLower;
    }

    public static function libraryLoader($class){
        $class = str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';
        $classLower = strtolower($class);

        if (is_readable(ROOT . "/libraries/" . $class))
            require_once ROOT . "/libraries/" . $class;

        else if (is_readable(ROOT . "/libraries/" . $classLower))
            require_once ROOT . "/libraries/" . $classLower;
    }
}