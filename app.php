<?php

require_once 'config.php';

spl_autoload_register(function($class) {
    include 'app/' . str_replace('\\', '/', $class) . '.php';
});

// TODO Request object
// parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

$router = new Router($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
require_once 'routes.php';
echo $router->resolve();
