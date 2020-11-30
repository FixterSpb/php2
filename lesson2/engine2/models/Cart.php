<?php


namespace app\models;


class Cart extends Model
{
    public $id;
    public $products = [];

    protected function getTableName()
    {
        return "Carts"; //Таблица корзин
    }

    public function addProduct(Product $product, int $quantity)
    {
        if(isset($this->products[$product->id]))
        {//TODO Здесь, наверное, должно быть еще обращение к БД ...
            $this->products[$product->id]->quantity += $quantity;
        }else{
            //TODO ... и здесь тоже. Как, впрочем, и в остальных методах...
            $this->products[$product->id] = new ProductCart($product, $quantity);
        }
    }

    public function removeProduct(int $id_product)
    {
        if(isset($this->products[$id_product]))
        {
            unset($this->products[$id_product]);
        }
    }

    public function getTotal()
    {
        return array_reduce($this->products,
                fn($accum, $item) => $accum + $item->getAmount(), 0);
    }

    public function toOrder(Order $order)
    {
        foreach ($this->products as $key => $value)
        {
            if ($value->selectedForOrder)
            {
                $order->products[$key] = $value;
            }
        }
    }
}