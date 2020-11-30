<?php


namespace app\models;


class Cart extends Model
{
    public $id;
    public $products = [];

    protected function getTableName()
    {
        return "Cart";
    }

    public function addProduct(Product $product, int $quantity)
    {
        if(isset($this->products[$product->id]))
        {//TODO Здесь, наверное, должно быть еще обращение к БД ...
            $this->products[$product->id]->quantity += $quantity;
        }else{
            //TODO ... и здесь тоже.
            $this->products[$product->id] = new ProductCart($product, $quantity);
        }
    }

    public function removeProduct(int $idProduct)
    {
        if(isset($this->products[$idProduct]))
        {
            unset($this->products[$idProduct]);
        }
    }

    public function getTotal()
    {
        $result = array_reduce($this->products, fn($accum, $item) => $accum + $item->getAmount(), 0);
        return $result;
    }
}