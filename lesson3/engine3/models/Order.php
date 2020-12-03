<?php


namespace app\models;


class Order extends Model
{

    public $id;
    public $user_id;
    public $user_comment;
    public $amount;
    public $status;

    /**
     * Orders constructor.
     * @param $user_id
     * @param $user_comment
     * @param $amount
     * @param $status
     */
    public function __construct($user_id, $amount = 0, $status = 'new', $user_comment = null)
    {
        $this->user_id = $user_id;
        $this->user_comment = $user_comment;
        $this->amount = $amount;
        $this->status = $status;
    }

    protected function getTableName()
    {
        return "orders";
    }




}