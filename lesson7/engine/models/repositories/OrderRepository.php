<?php


namespace app\models\repositories;

use app\engine\App;
use app\models\Repository;
use app\models\entities\Order;
use app\engine\Db;

class OrderRepository extends Repository
{

    public function getWhere($session_id = null){
        if (!$session_id) return $this->getAll();

        $tableName = $this->getTableName();
        $sql = "SELECT * FROM `$tableName` WHERE `session_id`=:session_id";
        return App::call()->db->queryAll($sql, ['session_id' => $session_id]);
    }

    protected function getEntityClass()
    {
        return Order::class;
    }

    protected function getTableName()
    {
        return 'orders';
    }
}