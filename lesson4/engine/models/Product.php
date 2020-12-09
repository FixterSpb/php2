<?php

namespace app\models;

class Product extends DBModel {
    protected $id;
    protected $name;
    protected $description;
    protected $price;
    protected $sale;
    protected $category_id;
    protected $main_img;
    protected $status;

    protected array $props = [
        'name' => false,
        'description' => false,
        'price' => false,
        'sale' => false,
        'category_id' => false,
        'main_img' => false,
        'status' => false,
    ];

//    protected function __construct($name = null, $description = null, $price = 0, $sale = 0,
//                                $category_id = 0, $main_img = null, $status = 'active')
//    {
//        $this->name = $name;
//        $this->category_id = $category_id;
//        $this->price = $price;
//        $this->sale = $sale;
//        $this->status = $status;
//        $this->main_img = $main_img;
//        $this->description = $description;
//
//    }

    public function __construct()
    {
        $values = func_get_args();
        if (count($values) === 1 && is_numeric($id = $values[0])){
            return $this->getOne_1($id);
        }

        $this->name = isset($values[0]) ? $values[0] : '';
        $this->category_id = isset($values[1]) ? $values[1] : 0;
        $this->price = isset($values[2]) ? $values[2] : 0;
        $this->sale = isset($values[3]) ? $values[3] : 0;
        $this->status = isset($values[4]) ? $values[4] : '';
        $this->main_img = isset($values[5]) ? $values[5] : '';
        $this->description = isset($values[6]) ? $values[6] : '';

    }
    static protected function getTableName() {
        return "products";
    }

}