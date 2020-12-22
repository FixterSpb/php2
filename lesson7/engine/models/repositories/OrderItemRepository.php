<?php


namespace app\models\repositories;

use app\engine\Db;
use app\models\entities\OrderItem;
use app\models\Repository;

class OrderItemRepository extends Repository
{
    public function getWhere($order_id){

        $tableName = $this->getTableName();
        $tableProduct = (new ProductRepository())->getTableName();
        $sql = "SELECT `$tableProduct`.`name` as 'name', `$tableName`.`price` as 'price',
                        `$tableName`.`qty` as 'qty', `$tableName`.`amount` as 'amount'
                        FROM `$tableName`
                        INNER JOIN `$tableProduct` ON `$tableName`.`product_id` = `$tableProduct`.`id`
                        WHERE `$tableName`.`order_id`=:order_id";
        return Db::getInstance()->queryAll($sql, ['order_id' => $order_id]);
    }

    protected function getEntityClass()
    {
        return OrderItem::class;
    }

    protected function getTableName()
    {
        return 'order_item';
    }
}