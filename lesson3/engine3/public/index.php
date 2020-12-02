<?php

//use app\models\{Product, User};
//use app\engine\Db;

include "../config/config.php";
include "../engine/Autoload.php";

use app\engine\Autoload;
use app\models\{Product, User};

use app\engine\Db;

spl_autoload_register([new Autoload(), 'loadClass']);

//CREATE
$product = new Product();


$cart = new \app\models\CartItem(1, 1, 10);
$cart->update();
//echo "<pre>";
//var_dump($cart);
//echo "</pre>";
//die;
$cart->delete();
die;
echo "<pre>";
var_dump($product);
echo "</pre>";

die();
//DELETE
$product = new Product();
$product = $product->getOne(5);
$product->delete();

//UPDATE
$product = new Product();
$product = $product->getOne(5);
$product->name = "Чай2";
$product->update();

var_dump($product);


die();

var_dump($product);

var_dump($product->getOne(1));

var_dump($product);


