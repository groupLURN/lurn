<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'Calendar',
    ['path' => '/calendar'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
