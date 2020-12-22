<?php

use app\models\entities\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @dataProvider providerConstruct
     */

    public function testConstruct($name, $description, $price, $sale,
                                  $category_id, $main_img, $status){
        $product = new Product($name, $description, $price, $sale,
            $category_id, $main_img, $status);
        $this->assertEquals($name, $product->name);
        $this->assertEquals($description, $product->description);
        $this->assertEquals($price, $product->price);
        $this->assertEquals($sale, $product->sale);
        $this->assertEquals($category_id, $product->category_id);
        $this->assertEquals($main_img, $product->main_img);
        $this->assertEquals($status, $product->status);
    }

    public function providerConstruct(){
        return [
            ['Продукт 1', 'Описание 1', 999.99, 10, 1, 'default_img', 'active'],
            ['Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus consequatur ea esse possimus quam quo? Ad, adipisci aperiam cupiditate debitis eligendi, est magnam maiores nemo nisi officiis porro, tempore voluptate.',
                'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus consequatur ea esse possimus quam quo? Ad, adipisci aperiam cupiditate debitis eligendi, est magnam maiores nemo nisi officiis porro, tempore voluptate.',
                -100.99, -5, -1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus consequatur ea esse possimus quam quo? Ad, adipisci aperiam cupiditate debitis eligendi, est magnam maiores nemo nisi officiis porro, tempore voluptate.',
                'Lorem ipsum dolor sit.'],
        ];
    }
}
