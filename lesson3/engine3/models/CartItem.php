<?php


namespace app\models;


class CartItem extends Model
{
    public $product_id;
    public $cart_id;
    public $qty;

    protected function getTableName(){
        return "cart_item";
    }
    public function __construct($product_id = null, $cart_id = null, $qty = null)
    {
        $this->product_id = $product_id;
        $this->cart_id = $cart_id;
        $this->qty = $qty;
    }


}