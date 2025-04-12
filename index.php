<?php
session_start();
//const BASE_PATH = __DIR__.'/../';
const BASE_PATH = __DIR__.'/';

//print(BASE_PATH);
//$functions = BASE_PATH.'Core/functions.php';
//print($functions);
require BASE_PATH.'Core/functions.php';

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class); // Converts MODELS\User => MODELS/User
    require __DIR__ . "/$class.php";
});


require base_path('bootstrap.php');

$router = new \Core\Router();
$routes = require base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
/* header('Content-Type: text/html; charset=utf-8');
require 'PHP/router.php'; */