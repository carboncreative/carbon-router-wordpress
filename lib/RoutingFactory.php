<?php

namespace Carbon\Router;

class RoutingFactory
{
    public static function getRouter($priority = 0)
    {
        return new Routing(new Klein, $priority);
    }
}
