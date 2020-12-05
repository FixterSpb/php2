<?php

namespace app\models;

class Product extends Model {
    public $name;
    public $description;
    public $price;
    public $sale;
    public $category_id;
    public $main_img;
    public $status;

    public function __construct($name = null, $description = null, $price = null,
                                $sale = 0, $category_id = null, $main_img = null, $status = 'active')
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->sale = $sale;
        $this->category_id = $category_id;
        $this->main_img = $main_img;
        $this->status = $status;
    }


    static protected function getTableName() {
        return "products";
    }

}