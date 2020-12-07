<?php

namespace app\models;

class Product extends DBModel {
    protected $name;
    protected $description;
    protected $price;
    protected $sale;
    protected $category_id;
    protected $main_img;
    protected $status;

    protected $props = [
        'name' => false,
        'description' => false,
        'price' => false,
        'sale' => false,
        'category_id' => false,
        'main_img' => false,
        'status' => false,
    ];

    public function __construct($name = null, $description = null, $price = null, $sale = null,
                                $category_id = null, $main_img = null, $status = null)
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