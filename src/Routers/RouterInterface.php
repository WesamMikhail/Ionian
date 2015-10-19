<?php
namespace Lorenum\Ionian\Routers;

use Lorenum\Ionian\Request\Request;

/**
 * Interface RouterInterface
 * This interface must be implemented in order for a router to be classified as such
 *
 *
 * @package Lorenum\Ionian\Routers
 */
Interface RouterInterface{

    /**
     * @param Request $request
     * @return Route|boolean
     */
    public function match(Request $request);
}