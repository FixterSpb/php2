<?php


namespace app\models;

use app\engine\Db;

class Basket extends DBModel
{
    protected $id;
    protected $product_id;
    protected $session_id;
    protected $qty;

    protected $props =
    [
        'product_id' => false,
        'session_id' => false,
        'qty' => false,
    ];

    public function __construct($product_id = null, $session_id = null, $qty = null)
    {
        $this->product_id = $product_id;
        $this->session_id = $session_id;
        $this->qty = $qty;
    }

    public static function getBasket($session_id) {
        $basketTable = static::getTableName();
        $productTable = Product::getTableName();
        $sql = "SELECT `{$basketTable}`.`id` as 'basket_id',
                        `{$basketTable}`.`qty` as 'qty',
                        `{$productTable}`.`id` as 'product_id',
                        `{$productTable}`.`name` as 'name',
                        `{$productTable}`.`price` as 'price',
                        `{$productTable}`.`price` * `{$basketTable}`.`qty` as 'amount'                        
                        FROM `{$basketTable}` 
                INNER JOIN `{$productTable}` ON `{$productTable}`.`id` = `{$basketTable}`.`product_id`
                WHERE `{$basketTable}`.`session_id` = :session_id";

        return Db::getInstance()->queryAll($sql, ['session_id' => $session_id]);
    }

    public static function getCount($session_id){
        $tableName = static::getTableName();
        $sql = "SELECT sum(qty) as 'sum' FROM {$tableName} WHERE `session_id` = :session_id";
        return Db::getInstance()->queryOne($sql, ['session_id' => $session_id])['sum'] ?: 0;
    }

    public static function getBasketItem($session_id, $product_id){
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `session_id` = :session_id AND `product_id` = :product_id";
        return Db::getInstance()->queryObject($sql,
            [
                'session_id' => $session_id,
                'product_id' => $product_id,
            ], static::class);
    }

    public static function add($session_id, $id){
//        $sql
    }

    protected static function getTableName(){
        return "basket";
    }


}