<?php


namespace app\models\entities;

use app\engine\Db;

class Basket extends Model
{
    protected $id;
    protected $product_id;
    protected $session_id;
    protected $qty;

    protected $props =
    [
        'product_id' => false,
        'session_id' => false,
        'qty' => false,
    ];

    public function __construct($product_id = null, $session_id = null, $qty = null)
    {
        $this->product_id = $product_id;
        $this->session_id = $session_id;
        $this->qty = $qty;
    }

}