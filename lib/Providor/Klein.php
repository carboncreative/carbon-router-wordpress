<?php
/**
 * File is part of the Carbon Router package
 */

namespace Carbon\Router\Providor;

use Klein\Klein as BaseKlein;
use Carbon\Router\Router;

/**
 * A wrapper for Klein
 *
 * @package Carbon\Router
 */
class Klein implements Router
{
    /** @var BaseKlein instance of Klein router */
    private $klein;

    /**
     * Initalise Klein
     */
    public function __construct()
    {
        $this->klein = new BaseKlein;
    }

    /**
     * Adds a route to a router
     *
     * @param  string   $method
     * @param  string   $route
     * @param  callable $callback
     * @return void
     */
    public function addRoute($method, $route, $callback)
    {
        $this->klein->respond($method, $route, $callback);
    }

    /**
     * Checks current route for matches stored in the Router instance and calls the callback if found
     *
     * @return void
     */
    public function dispatch()
    {
        $this->klein->dispatch();
    }
}
