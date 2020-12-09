<?php


namespace app\controllers;


use app\models\Basket;

class BasketController extends Controller
{
    public function actionIndex(){
        $basket = Basket::getBasket(25);
        echo $this->render('basket', ['basket' => $basket]);
    }
}