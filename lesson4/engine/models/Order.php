<?php


namespace app\models;


class Order extends Model
{
    protected $id;
    protected $user_id;
    protected $user_comment;
    protected $amount;
    protected $status;
    protected $props =
        [
            'user_id' => false,
            'user_comment' => false,
            'amount' => false,
            'status' => false,
        ];

    public function __construct($user_id, $amount = 0, $status = 'new', $user_comment = null)
    {
        $this->user_id = $user_id;
        $this->user_comment = $user_comment;
        $this->amount = $amount;
        $this->status = $status;
    }

    static protected function getTableName()
    {
        return "orders";
    }




}