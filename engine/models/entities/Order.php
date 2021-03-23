<?php


namespace app\models\entities;


class Order extends Model
{
    protected $id;
    protected $session_id;
    protected $name;
    protected $email;
    protected $phone;
    protected $comment;
    protected $status;
    protected $total;

    protected $props =
        [
            'session_id' => false,
            'name' => false,
            'email' => false,
            'phone' => false,
            'comment' => false,
            'status' => false,
            'total' => false,
        ];

    public function __construct($session_id = null, $name = null, $email = null, $phone = null, $comment = null, $status = 'new', $total = null)
    {
        $this->session_id = $session_id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->comment = $comment;
        $this->status = $status;
        $this->total = $total;
    }

    static protected function getTableName()
    {
        return "orders";
    }




}