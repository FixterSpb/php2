<?php


namespace app\controllers;


use app\engine\App;

class OrdersController extends Controller
{
    public function actionIndex(){
        $role = App::call()->session->role;
        if ($role === 'admin'){
            $orders = App::call()->orderRepository->getWhere();
        }else {
            $orders = App::call()->orderRepository->getWhere(App::call()->session->getId());
        }

        echo $this->render('ordersAll',
            [
                'orders' => $orders,
                'role' => $role,
            ]
        );
    }
}