<?php


namespace app\models;


class Cart extends Model
{
    public $id;
    public $user_id;

    public function __construct($user_id = null)
    {
        $this->user_id = $user_id;
    }

    protected function getTableName()
    {
        return "carts";
    }
}