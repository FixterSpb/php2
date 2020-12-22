<?php

namespace app\models\repositories;

use app\engine\App;
use app\engine\Db;
use app\models\Repository;
use app\models\entities\Basket;

class BasketRepository extends Repository
{

    public function getBasket($session_id) {
        $basketTable = $this->getTableName();
        $productTable = App::call()->productRepository->getTableName();
        $sql = "SELECT `{$basketTable}`.`id` as 'basket_id',
                        `{$basketTable}`.`qty` as 'qty',
                        `{$productTable}`.`id` as 'product_id',
                        `{$productTable}`.`name` as 'name',
                        `{$productTable}`.`price` as 'price',
                        `{$productTable}`.`price` * `{$basketTable}`.`qty` as 'amount'                        
                        FROM `{$basketTable}` 
                INNER JOIN `{$productTable}` ON `{$productTable}`.`id` = `{$basketTable}`.`product_id`
                WHERE `{$basketTable}`.`session_id` = :session_id";

        return App::call()->db->queryAll($sql, ['session_id' => $session_id]);
    }

    public function getCount($session_id){
        $tableName = $this->getTableName();
        $sql = "SELECT sum(qty) as 'sum' FROM {$tableName} WHERE `session_id` = :session_id";
        $result = App::call()->db->queryOne($sql, ['session_id' => $session_id]) ?: [];
        return array_get($result, 'sum', 0);
    }

    public function getBasketItem($session_id, $product_id){
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM $tableName WHERE `session_id` = :session_id AND `product_id` = :product_id";
        return App::call()->db->queryObject($sql,
            [
                'session_id' => $session_id,
                'product_id' => $product_id,
            ], $this->getEntityClass());
    }

    protected function getEntityClass()
    {
        return Basket::class;
    }

    protected function getTableName()
    {
        return 'basket';
    }
}