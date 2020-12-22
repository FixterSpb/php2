<?php

namespace app\controllers;

use app\models\Product;

class ProductController extends Controller
{


    public function actionIndex()
    {
        echo $this->render('index');
    }

    public function actionCatalog()
    {
        $page = array_get($this->app->getRequest()->getParams(), 'page', 1);
        $catalog = Product::getLimit($page * PRODUCT_PER_PAGE);

        echo $this->render('catalog', [
            'catalog' => $catalog,
            'page' => ++$page
        ]);
    }

    public function actionCard()
    {
        $id = array_get($this->app->getRequest()->getParams(), 'id');
        echo $this->render('card', [
            'product' => Product::getOne($id)
        ]);
    }
}