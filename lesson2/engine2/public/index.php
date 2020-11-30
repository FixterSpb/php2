<?php

use app\models\{Product, User, Cart, Order};
use app\engine\Db;

include "../engine/Autoload.php";


spl_autoload_register([new Autoload(), 'loadClass']);


$product = new Product(new Db());
$product->id = 1;

$product->price = 50;

var_dump($product);
var_dump($product->getOne(5));

$user = new User(new Db());
$user->login = "Alex";
var_dump("<br>", $user->getAll());

$cart = new Cart(new Db());
var_dump("<br>", $cart->getOne(5));

$cart->addProduct($product, 10);
var_dump($cart->products);

$cart->addProduct($product, 15);

$product2 = new Product(new Db());
$product2->id = 2;
$product2->price = 10;
$cart->addProduct($product2, 10);

$product3 = new Product(new Db());
$product3->id = 3;
$product3->price = 30;
$cart->addProduct($product3, 10);
$cart->products[3]->selectedForOrder = true;

$product4 = new Product(new Db());
$product4->id = 4;
$product4->price = 40;
$cart->addProduct($product4, 10);

$product5 = new Product(new Db());
$product5->id = 5;
$product5->price = 10;
$cart->addProduct($product5, 10);
$cart->products[5]->selectedForOrder = true;
$cart->removeProduct(2);

var_dump($cart);
echo "Сумма товаров в корзине: ";
var_dump($cart->getTotal());

$order = new Order(new Db());
$cart->toOrder($order);
var_dump($order);
echo "Сумма товаров в заказе: ";
var_dump($order->getTotal());

echo "<h1>Задание 3</h1>";
use app\models\example\{Digital, Piece, Weight};
$product1 = new Digital("Продукт №1", 100);
$product1->buy(15);

$product2 = new Piece("Продукт №1", 100);
$product2->buy(15);

$product3 = new Weight("Продукт №1", 100);
$product3->buy(15);

echo "<br>";
echo "Общий доход составил: ", $product1->getProfit(), " руб. <br>";
//  Т.к. метод обращается к статичному полю,
// то его вызов из любого экземпляра приведет к одному результату:
echo "Общий доход составил: ", $product2->getProfit(), " руб. <br>";
echo "Общий доход составил: ", $product3->getProfit(), " руб. <br>";

//Ну и, так как метод тоже статический, можно и так:
echo "Общий доход составил: ", app\models\example\Product::getProfit(), " руб. <br>";
echo "Общий доход составил: ", Digital::getProfit(), " руб. <br>";
