<?php
ini_set("display_errors", 1);
error_reporting(E_ALL^E_NOTICE);
$uri = $_GET['uri'];
$uri = explode("/",$uri);

$controller = array_shift($uri);
$action = array_shift($uri);

$controllerName = '\\MVCProject\\Controllers\\' . ucfirst($controller) . "Controller";

spl_autoload_register(function($class){
    $splitted = explode("\\", $class);
    array_shift($splitted);
    $fullPath = implode(DIRECTORY_SEPARATOR,$splitted);
   require_once $fullPath . '.php';
});

MVCProject\View::$controllerName = $controller;
MVCProject\View::$actionName = $action;

$controllerInstance = new $controllerName();

call_user_func_array(
    array($controllerInstance, $action),
    $uri
);

