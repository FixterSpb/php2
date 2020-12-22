<?php


namespace app\controllers;


use app\models\entities\Order;
use app\models\entities\OrderItem;
use app\models\repositories\BasketRepository;
use app\models\repositories\OrderItemRepository;
use app\models\repositories\OrderRepository;

class OrderController extends Controller
{
    public function actionIndex(){

    }

    public function actionAdd(){
        $data = $this->app->getRequest()->getParams();
//        dd($data);
        $name = array_get($data, 'name');
        $email = array_get($data, 'email');
        $phone = array_get($data, 'phone');
        $comment = array_get($data, 'comment');
        $total = array_get($data, 'total');

        $session_id = $this->app->getSession()->getId();

        $order = new Order($session_id, $name, $email, $phone, $comment, 'new', $total);
        (new OrderRepository())->save($order);

        $basketRepository = new BasketRepository();
        $basket = $basketRepository->getBasket($session_id);
        foreach ($basket as $value){

            $orderItem = new OrderItem($order->id, $value['product_id'], $value['price'], $value['qty'], 0, $value['amount']);
            (new OrderItemRepository())->save($orderItem);

            $basketRepository->delete($basketRepository->getOne($value['basket_id']));
        }

        header("Location: /orders/");
    }

    public function actionCreate(){
        $basket = (new BasketRepository())->getBasket($this->app->getSession()->getId());
        $total = array_reduce($basket, fn($accum, $item) => $accum + $item['amount'], 0);
        echo $this->render('order',
            [
                'order' => $basket,
                'total' => $total,
                'create' => true,
            ]);
    }

    public function actionBrowse(){
        $id = $this->app->getRequest()->getParams()['id'];
        $orderData = (new OrderRepository())->getOne($id);
        $role = $this->app->getSession()->role;

        if ($this->app->getSession()->getId() !== $orderData->session_id &&
            $role !== 'admin') {
            header("Location: ". $this->app->getRequest()->getReferer());
        }
//        dd($this->app->getSession()->getId() !== $orderData->session_id);
        $order = (new OrderItemRepository())->getWhere($id);
        echo $this->render('order',
            [
                'role' => $role,
                'order' => $order,
                'orderData' => $orderData,
                'total' => $orderData->total,
            ]
        );
    }

    public function actionUpdate(){
        $params = $this->app->getRequest()->getParams();
        $orderRepository = new OrderRepository();
        $order = $orderRepository->getOne(array_get($params, 'id'));
        $order->status = array_get($params, 'status');
        $orderRepository->save($order);
        header("Location: " . $this->app->getRequest()->getReferer());
    }

}