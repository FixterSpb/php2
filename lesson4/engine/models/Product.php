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

    public function __call($name, $args){
        echo $name;
    }
//    public function __callStatic($name, $args){
//        echo $name;
//    }

    public function constructor($name, $description = null, $price = null, $sale = null,
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

    public function __construct(){
        $argsCount = func_num_args();
        $args = func_get_args();
        var_dump($args);

        if ($argsCount === 1 && is_numeric($args[0])) {
            static::getOne($args[0]);
        }else{
            var_dump($args);
        }
    }

    static protected function getTableName() {
        return "products";
    }

}