<?php


namespace app\models;

use app\engine\Db;

class Basket extends DBModel
{
    protected $id;
    protected $product_id;
    protected $cart_id;
    protected $qty;

    protected $props =
    [
        'product_id' => true,
        'cart_id' => true,
        'qty' => true,
    ];

    static protected function getTableName(){
        return "cart_item";
    }

    public static function getBasket($session_id) {
        $basketTable = static::getTableName();
        $cartsTable = Cart::getTableName();
        $productTable = Product::getTableName();
        $sql = "SELECT * FROM `{$basketTable}` 
                INNER JOIN `{$cartsTable}` ON `{$cartsTable}`.`id` = `{$basketTable}`.`cart_id`
                INNER JOIN `{$productTable}` ON `{$productTable}`.`id` = `{$basketTable}`.`product_id` 
                WHERE `{$cartsTable}`.`user_id` = :session_id";
        return Db::getInstance()->queryAll($sql, ['session_id' => $session_id]);
    }

    public function __construct($product_id = null, $cart_id = null, $qty = null)
    {
        $this->product_id = $product_id;
        $this->cart_id = $cart_id;
        $this->qty = $qty;
    }

}