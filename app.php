<?php

require_once 'config.php';

spl_autoload_register(function($class) {
    include 'app/' . str_replace('\\', '/', $class) . '.php';
});

$router = new Router($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
require_once 'routes.php';
echo $router->resolve();
