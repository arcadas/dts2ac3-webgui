<?php

$router->get('/', function() {
    return (new Controller)->list();
});
$router->get('/scan', function() {
    return (new Controller)->scan();
});
$router->get('/scan_all', function() {
    return (new Controller)->scanAll();
});
$router->get('/convert', function() {
    return (new Controller)->convert();
});
