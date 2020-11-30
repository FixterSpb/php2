<?php

use app\models\{Product, User, Cart};
use app\engine\Db;

include "../engine/Autoload.php";


spl_autoload_register([new Autoload(), 'loadClass']);


$product = new Product(new Db());

$product->price = 50;

var_dump($product);

//var_dump($product->getOne(5));


$user = new User(new Db());
var_dump("<br>", $user->getAll());

$cart = new Cart(new Db());
var_dump("<br>", $cart->getOne(5));

$cart->addProduct($product, 10);
var_dump($cart->products);

$cart->addProduct($product, 15);

echo "<br>";
var_dump($cart->getTotal());
echo "<br>";
var_dump($cart->products);


