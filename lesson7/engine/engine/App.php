<?php


namespace app\engine;

use app\models\repositories\BasketRepository;
use app\models\repositories\OrderItemRepository;
use app\models\repositories\OrderRepository;
use app\models\repositories\ProductRepository;
use app\models\repositories\UserRepository;
use app\traits\TSingletone;
use app\engine\Session;
use app\engine\Request;
use app\engine\Render;

/**
 * Class App
 * @property Request $request
 * @property Session $session
 * @property Render $render
 * @property BasketRepository $basketRepository
 * @property UserRepository $usersRepository
 * @property ProductRepository $productRepository
 * @property OrderRepository $orderRepository
 * @property OrderItemRepository $orderItemRepository
 * @property Db $db
 */
class App
{
    use TSingletone;

    public $config;
    private $components;

    private $controller;
    private $action;

    public function run($config)
    {
        $this->config = $config;
        $this->components = new Storage();
        $this->runController();
    }

    public function runController()
    {
        $this->controller = $this->request->getControllerName() ?: 'product';
        $this->action = $this->request->getActionName();

        $controllerClass = $this->config['controllers_namespaces'] . ucfirst($this->controller) . "Controller";

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass(new Render());
            $controller->runAction($this->action);
        } else {
            echo "Не правильный контроллер";
        }
    }

    /**
     * @return static
     */
    public static function call()
    {
        return static::getInstance();
    }

    //создание компонента при обращении, возвращает объект для хранилища
    public function createComponent($name)
    {
        if (isset($this->config['components'][$name])) {
            $params = $this->config['components'][$name];
            $class = $params['class'];
            if (class_exists($class)) {
                unset($params['class']);
                //воспользуемся библиотекой ReflectionClass для создания класса
                //просто return new $class нельзя
                // т.к. не будут переданы параметры для конструктора
                $reflection = new \ReflectionClass($class);
                return $reflection->newInstanceArgs($params);
            }
        }
        return null;
    }

    //Чтобы обращаться к компонентам как к свойствам, переопределим геттер
    public function __get($name)
    {
        return $this->components->get($name);
    }

}