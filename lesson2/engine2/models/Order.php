<?php


namespace app\models;


use app\engine\Db;

class Order extends Cart
{
    protected function getTableName()
    {
        return "Orders";
    }

    public function checkout()
    {
        //Правда, пока мало представяю, как реализовать оформление заказа...
    }
}