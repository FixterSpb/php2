<?php


namespace app\controllers;


use app\models\repositories\OrderRepository;

class OrdersController extends Controller
{
    public function actionIndex(){
        $role = $this->app->getSession()->role;
        if ($role === 'admin'){
            $orders = (new OrderRepository())->getWhere();
        }else {
            $orders = (new OrderRepository())->getWhere($this->app->getSession()->getId());
        }

        echo $this->render('ordersAll',
            [
                'orders' => $orders,
                'role' => $role,
            ]
        );
    }
}