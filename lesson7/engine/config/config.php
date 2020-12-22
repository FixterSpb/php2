<?php
use app\engine\Db;
use app\engine\Request;
use app\engine\Session;
use app\engine\Render;
use app\models\repositories\BasketRepository;
use app\models\repositories\ProductRepository;
use app\models\repositories\UserRepository;
use app\models\repositories\OrderItemRepository;
use app\models\repositories\OrderRepository;

return [
    'root_dir' =>  dirname(__DIR__),
    'templates_dir' => dirname(__DIR__) . "/views/",
    'controllers_namespaces' => 'app\controllers\\',
    'components' => [
        'db' => [
            'class' => Db::class,
            'driver' => 'mysql',
            'host' => 'localhost',
            'login' => 'root',
            'password' => '',
            'database' => 'shop',
            'charset' => 'utf8'
        ],
        'request' => [
            'class' => Request::class
        ],
        'basketRepository' => [
            'class' => BasketRepository::class
        ],
        'productRepository' => [
            'class' => ProductRepository::class
        ],
        'usersRepository' => [
            'class' => UserRepository::class
        ],
        'orderItemRepository' => [
            'class' => OrderItemRepository::class
        ],
        'orderRepository' => [
            'class' => OrderRepository::class
        ],
        'render' => [
            'class' => Render::class
        ],

        'session' => [
            'class' => Session::class
        ]
    ]
];