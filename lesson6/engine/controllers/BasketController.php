<?php


namespace app\controllers;
use app\engine\Request;
use app\models\{Basket, User};

class BasketController extends Controller
{
    public function actionIndex(){
        $basket = Basket::getBasket($this->app->getSession()->getId());
        $total = array_reduce($basket, fn($accum, $item) => $accum + $item['amount'], 0);
        echo $this->render('basket', ['basket' => $basket, 'total' => $total]);
    }

    public function actionAdd() {

        $product_id = $this->app->getRequest()->getParams()['id'];
        $session_id = $this->app->getSession()->getId();

        if(!$basketItem = Basket::getBasketItem($session_id, $product_id)){
            $basketItem = new Basket($product_id, $session_id, 0);
        };

        $basketItem->qty++;
        $basketItem->save();

        $response = [
            'countBasket' => Basket::getCount($session_id),
            'status' => 'ok',
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function actionDelete(){
        $params = $this->app->getRequest()->getParams();
        $basket_id = $params['basket_id'];
        $dec = $params['qty'];
        $basketItem = Basket::getOne($basket_id);
        $basketItem->qty -= $dec;
        if ($basketItem->qty > 0){
            $basketItem->save();
        }else {
            $basketItem->delete();
        }


        $response = [
            'countBasket' => Basket::getCount($basketItem->session_id),
            'qty' => $basketItem->qty,
            'status' => 'ok',
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}