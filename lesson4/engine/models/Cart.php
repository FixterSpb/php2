<?php


namespace app\models;


class Cart
    extends DBModel
{
    protected int $id;
    protected int $user_id;
    protected $props = [
        'user_id' => false,
    ];



    public function constructor($user_id = null)
    {
        $this->user_id = $user_id;
    }

    static protected function getTableName()
    {
        return "carts";
    }
}