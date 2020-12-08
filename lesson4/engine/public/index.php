<?php

include "../config/config.php";
include "../engine/Autoload.php";

use app\engine\Autoload;
use app\models\{Product, User, Cart, CartItem, Category};

use app\engine\Db;

spl_autoload_register([new Autoload(), 'loadClass']);

$product = new Product(1);
//$product->new();
//$product = new Product('Наименование товара', 'Описание', 31999, 0, 1, '', 'active');
//$product = Product::getOne(12);
//$product->price = 21999;
//$product->save();
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