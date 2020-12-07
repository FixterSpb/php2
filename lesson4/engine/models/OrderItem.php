<?php


namespace app\models;


class OrderItem extends Model
{
    public $order_id;
    public $product_id;
    public $price;
    public $qty;
    public $sale;
    public $amount;

    public function __construct($order_id = null, $product_id = null,
                                $price = null, $qty = null,
                                $sale = null, $amount = null)
    {
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->price = $price;
        $this->qty = $qty;
        $this->sale = $sale;
        $this->amount = $amount;
    }


    static protected function getTableName()
    {
        return "order_item";
    }
}