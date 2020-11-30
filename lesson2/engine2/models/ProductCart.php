<?php


namespace app\models;


use app\engine\Db;


class ProductCart extends Product
{
    public $quantity;

    public function __construct(Product $product, int $quantity)
    {
        parent::__construct($product->db);
        $this->quantity = $quantity;
        $this->id = $product->id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->description = $product->description;
    }

    public function getAmount()
    {
        return $this->price * $this->quantity;
    }

    public function removeFromCart($quantity)
    {
        $this->cart->removeProduct($this->id, $quantity);
    }
}