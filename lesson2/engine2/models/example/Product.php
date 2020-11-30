<?php

namespace app\models\examples;

class Product extends Model {
    public $id;
    public $name;
    public $description;
    public $price;

    protected function getTableName() {
        return "Product";
    }

}