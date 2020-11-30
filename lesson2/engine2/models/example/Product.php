<?php

namespace app\models\example;

abstract class Product{
    protected $name;
    protected $group;
    protected $price;
    protected $factor;
    protected $unitName;
    static private $profit;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function buy($quantity){
        $cost = $this->price * $this->factor * $quantity;
        self::$profit += $cost;
        echo "Куплен $this->group, $this->name, в количестве $quantity $this->unitName. Стоимость составила: $cost руб.";
    }

    static public function getProfit(){
        return self::$profit;
    }
}