<?php


namespace app\controllers;

use app\engine\App;
use app\engine\Request;
use app\models\entities\Basket;
use app\models\entities\User;
use app\models\repositories\BasketRepository;


class BasketController extends Controller
{
    public function actionIndex(){
        $basket = App::call()->basketRepository->getBasket(
            App::call()->session->getId());
        $total = array_reduce($basket, fn($accum, $item) => $accum + $item['amount'], 0);
        echo $this->render('basket', ['basket' => $basket, 'total' => $total]);
    }

    public function actionAdd() {

        $product_id = App::call()->request->getParams()['id'];
        $session_id = App::call()->session->getId();

        $basketRepository = App::call()->basketRepository;

        if(!$basketItem = $basketRepository->getBasketItem($session_id, $product_id)){
            $basketItem = new Basket($product_id, $session_id, 0);
        };

        $basketItem->qty++;
        $basketRepository->save($basketItem);

        $response = [
            'countBasket' => $basketRepository->getCount($session_id),
            'status' => 'ok',
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function actionDelete(){
        $params = App::call()->request->getParams();
        $basket_id = $params['basket_id'];
        $dec = $params['qty'];
        $basketRepository = App::call()->basketRepository;
        $basketItem = $basketRepository->getOne($basket_id);

        if($basketItem->session_id === App::call()->session->getId()){
            $basketItem->qty -= $dec;
            if ($basketItem->qty > 0){
                $basketRepository->save($basketItem);
            }else {
                $basketRepository->delete($basketItem);
            }

            $countBasket = $basketRepository->getCount($basketItem->session_id);


            $response = [
                'countBasket' => $countBasket,
                'qty' => $basketItem->qty,
                'status' => 'ok',
            ];
        }else{
            $response = [
                'countBasket' => $basketRepository->getCount($basketItem->session_id),
                'qty' => $basketItem->qty,
                'message' => 'Неверная корзина',
                'status' => 'error',
            ];
        }


        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}