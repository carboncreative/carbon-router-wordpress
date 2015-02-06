<?php

namespace Carbon\Router;

use Carbon\Router\Providor\Klein;

class RoutingFactory
{
    public static function getRouter($priority = 0)
    {
        return new Routing(new Klein, $priority);
    }
}
