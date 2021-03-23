<?php


namespace app\models\entities;


class OrderItem extends Model
{
    protected $id;
    protected $order_id;
    protected $product_id;
    protected $price;
    protected $qty;
    protected $sale;
    protected $amount;

    protected $props =
        [
            'order_id' => false,
            'product_id' => false,
            'price' => false,
            'qty' => false,
            'sale' => false,
            'amount' => false,
        ];

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