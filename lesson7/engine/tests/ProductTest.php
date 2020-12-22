<?php

use app\models\entities\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    public function testConstruct(){
        $product = new Product('name', 'description', 999.99, 10, 1, 'main_img', 'deleted');
        $this->assertEquals('name', $product->name);
        $this->assertEquals('description', $product->description);
        $this->assertEquals(999.99, $product->price);
        $this->assertEquals(10, $product->sale);
        $this->assertEquals(1, $product->category_id);
        $this->assertEquals('main_img', $product->main_img);
        $this->assertEquals('deleted', $product->status);
    }
}