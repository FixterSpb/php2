<?php

include "../config/config.php";
include "../engine/Autoload.php";

use app\engine\Autoload;
use app\models\{Product, User, Cart, CartItem, Category};

use app\engine\Db;

spl_autoload_register([new Autoload(), 'loadClass']);

/*
 * Интересно было посмотреть, как будут добавляться товары в корзину,
 * поэтому удалил уникальный ключ из users.name и экспериментировал.
 * В ключевых местах die не стал удалять, а просто закомментировал.
 */



//CREATE
$user = new User('Alex', '111');
$user->insert();

$cart = new Cart($user->id);
$cart->insert();

$product = new Product();
$product->getOne(1);

$cartItem = new CartItem($product->id, $cart->id, 10);
$cartItem->insert();

var_dump($user, $cart, $product, $cartItem);
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


/* С категориями тоже экспериментировал.
 *
$category = new Category('Чай');
$category->insert();

$product = new Product('Принцесса Дури', 'Вкусный цейлонский чай', 55, 0, $category->id);
$product->insert();

var_dump($category, $product);

*/