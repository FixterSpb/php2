<?php

include "../config/config.php";
include "../engine/Autoload.php";
require_once '../vendor/autoload.php';
require_once '../helpers/helper.php';

use app\engine\{Autoload, Render, TwigRender};
use app\models\{Product, User, Cart, CartItem, Category, Basket};

use app\engine\Db;

spl_autoload_register([new Autoload(), 'loadClass']);

//Отбросил get-параметры:
$url = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

//В этом случае на странице вываливаются Notice (что, в том числе, может сломать json-ответ):
//$controllerName = $url[1] ?: 'product';
//$actionName = $url[2];

//Поэтому добавил функцию, она заодно экранирует спецсимволы и убирает html-тэги:
$controllerName = array_get($url, 1, 'product');
$actionName = array_get($url, 2);

$controllerClass =  CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

if (class_exists($controllerClass)) {
    $controller = new $controllerClass(new TwigRender());
    $controller->runAction($actionName);
}