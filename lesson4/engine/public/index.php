<?php

include "../config/config.php";
include "../engine/Autoload.php";

use app\engine\Autoload;
use app\models\{Product, User, Cart, CartItem, Category, Basket};

use app\engine\Db;

spl_autoload_register([new Autoload(), 'loadClass']);


$controllerName = isset($_GET['c']) ? $_GET['c'] : 'product';
$actionName = isset($_GET['a']) ? $_GET['a'] : null;

$controllerClass =  CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    $controller->runAction($actionName);
}



//$product = new Product(1);
//$product->new();
//$product = new Product('Наименование товара', 'Описание', 31999, 0, 1, '', 'active');
//$product = Product::getOne(13);
//$product->price = 55;
//var_dump($product);
//$product->save();
//var_dump($product);
//
//$product->id = "fvndsrhsfvhn";
//var_dump($product);


/*
 * Интересно было посмотреть, как будут добавляться товары в корзину,
 * поэтому удалил уникальный ключ из users.name и экспериментировал.
 * В ключевых местах die не стал удалять, а просто закомментировал.
 */
/*
//CREATE

$user = new User('Alex', '111');
$user->insert();

$cart = new Cart($user->id);
$cart->insert();

$product = Product::getOne(1);

$cartItem = new CartItem($product->id, $cart->id, 10);
$cartItem->insert();

//var_dump($user, $cart, $product, $cartItem);
//die;

//UPDATE
$cartItem->qty = 5;
$cartItem->update();

var_dump($cartItem);
//die;

//DELETE
$cartItem->delete();
$cart->delete();
$user->delete();
die;
*/