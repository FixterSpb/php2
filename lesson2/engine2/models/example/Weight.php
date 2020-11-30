<?php


namespace app\models\example;


class Weight extends Product
{
    protected $group = "Весовой товар";
    protected $factor = 1;
    protected $unitName = "кг.";
}