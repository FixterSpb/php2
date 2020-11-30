<?php


namespace app\models;


use app\engine\Db;


class ProductCart extends Product
{

    //public $id - унаследованное поле - id таблицы Cart
    public $id_product; // id таблицы товаров
    public $quantity;
    public $selectedForOrder = false;

    protected function getTableName()
    {
        return 'Cart'; // Таблица, в которой хранятся продукты, добавленные в корзину и id корзины
    }

    public function __construct(Product $product, int $quantity)
    {
        parent::__construct($product->db);
        $this->quantity = $quantity;
        $this->id_product = $product->id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->description = $product->description;
    }

    public function getAmount()
    {
        return $this->price * $this->quantity;
    }

    public function removeFromCart(Cart $cart, int $quantity)
    {
        $cart->removeProduct($this->id_product, $quantity);
    }

}