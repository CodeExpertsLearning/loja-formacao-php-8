<?php
require __DIR__ . '/../bootstrap.php';

$url = ltrim($_SERVER['REQUEST_URI'], '/');
$url = explode('/', $url);

$controller = isset($url[0]) && $url[0] ? $url[0] : 'home';
$method     = isset($url[1]) && $url[1] ? $url[1] : 'index';
$params     = isset($url[2]) && $url[2] ? [$url[2]] : [];

$controller = '\\Controller\\' . ucfirst($controller) . 'Controller';

if(!class_exists($controller)
  || !method_exists(new $controller, $method)) {
    die('Página não encontrada!');
}

call_user_func_array([new $controller(), $method], $params);