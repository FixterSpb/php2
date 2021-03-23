<?php


namespace app\controllers;


use app\engine\App;
use app\models\entities\Order;
use app\models\entities\OrderItem;

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

    public function actionAdd(){
        $data = App::call()->request->getParams();
        $name = array_get($data, 'name');
        $email = array_get($data, 'email');
        $phone = array_get($data, 'phone');
        $comment = array_get($data, 'comment');
        $total = array_get($data, 'total');

        $session_id = App::call()->session->getId();

        $order = new Order($session_id, $name, $email, $phone, $comment, 'new', $total);
        App::call()->orderRepository->save($order);

        $basketRepository = App::call()->basketRepository;
        $basket = $basketRepository->getBasket($session_id);
        foreach ($basket as $value){

            $orderItem = new OrderItem($order->id, $value['product_id'], $value['price'], $value['qty'], 0, $value['amount']);
            App::call()->orderItemRepository->save($orderItem);
            if ($orderItem){
                $basketRepository->delete($basketRepository->getOne($value['basket_id']));
            }
        }

        header("Location: /orders/");
    }

    public function actionCreate(){
        $basket = App::call()->basketRepository
            ->getBasket(App::call()->session->getId());
        $total = array_reduce($basket, fn($accum, $item) => $accum + $item['amount'], 0);
        echo $this->render('order',
            [
                'order_items' => $basket,
                'total' => $total,
                'create' => true,
            ]);
    }

    public function actionBrowse(){
        $id = App::call()->request->getParams()['id'];
        $order = App::call()->orderRepository->getOne($id);
        $role = App::call()->session->role;

        if (App::call()->session->getId() !== $order->session_id &&
            $role !== 'admin') {
            header("Location: ". App::call()->request->getReferer());
        }
//        dd($this->app->getSession()->getId() !== $orderData->session_id);
        $order_items = App::call()->orderItemRepository->getWhere($id);
        echo $this->render('order',
            [
                'role' => $role,
                'order_items' => $order_items,
                'order' => $order,
                'total' => $order->total,
            ]
        );
    }

    public function actionUpdate(){
        $params = App::call()->request->getParams();
        $orderRepository =App::call()->orderRepository;
        $order = $orderRepository->getOne(array_get($params, 'id'));
        $order->status = array_get($params, 'status');
        $orderRepository->save($order);
        echo json_encode([
            'status' => 'ok'
        ]);
    }
}