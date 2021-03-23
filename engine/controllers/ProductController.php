<?php

namespace app\controllers;

use app\engine\App;
use app\models\Product;
use app\models\repositories\ProductRepository;

class ProductController extends Controller
{


    public function actionIndex()
    {
        echo $this->render('index');
    }

    public function actionCatalog()
    {
        $page = array_get(App::call()->request->getParams(), 'page', 1);
        $catalog = App::call()->productRepository
            ->getLimit($page * App::call()->config['product_per_page']);

        echo $this->render('catalog', [
            'catalog' => $catalog,
            'page' => ++$page
        ]);
    }

    public function actionCard()
    {
        $id = array_get(App::call()->request->getParams(), 'id');
        echo $this->render('card', [
            'product' => App::call()->productRepository->getOne($id)
        ]);
    }
}