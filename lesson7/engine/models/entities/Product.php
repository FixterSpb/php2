<?php

namespace app\models;

class Product extends Model {
    protected $id;
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

    protected function __construct($name = null, $description = null, $price = 0, $sale = 0,
                                $category_id = 0, $main_img = null, $status = 'active')
    {
        $this->name = $name;
        $this->category_id = $category_id;
        $this->price = $price;
        $this->sale = $sale;
        $this->status = $status;
        $this->main_img = $main_img;
        $this->description = $description;

    }

}