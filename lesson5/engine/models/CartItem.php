<?php


namespace app\models;


class CartItem extends DBModel
{
    protected $id;
    protected $product_id;
    protected $cart_id;
    protected $qty;
    protected $props = [
        'product_id' => false,
        'cart_id' => false,
        'qty' => false,
    ];

    static protected function getTableName(){
        return "cart_item";
    }

    public function __construct($product_id = null, $cart_id = null, $qty = null)
    {
        $this->product_id = $product_id;
        $this->cart_id = $cart_id;
        $this->qty = $qty;
    }

}