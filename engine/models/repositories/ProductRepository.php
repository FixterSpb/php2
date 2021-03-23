<?php


namespace app\models\repositories;

use app\models\Repository;

class ProductRepository extends Repository
{

    protected function getEntityClass()
    {
        return Product::class;
    }

    public function getTableName()
    {
        return 'products';
    }
}