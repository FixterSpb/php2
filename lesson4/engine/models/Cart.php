<?php


namespace app\models;


class Cart extends DBModel
{
    protected $id;
    public $user_id;

    public function __construct($user_id = null)
    {
        $this->user_id = $user_id;
    }

    static protected function getTableName()
    {
        return "carts";
    }
}