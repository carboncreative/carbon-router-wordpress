<?php
/**
 * File is part of the Carbon Router package
 */

namespace Carbon\Router;

/**
 * Router
 *
 * @package Carbon\Klein
 */
interface Router
{
    /**
     * Adds a get route to a router
     *
     * @param  string   $method
     * @param  string   $route
     * @param  callable $callback
     * @return void
     */
    public function addRoute($method, $route, $callback);

    /**
     * Checks current route for matches stored in the Router instance and calls the callback if found
     *
     * @return void
     */
    public function dispatch();
}
