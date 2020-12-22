<?php


namespace app\controllers;

use app\interfaces\IRenderer;
use app\models\{repositories\BasketRepository, repositories\UserRepository, User, Basket};
use app\engine\App;

class Controller
{
    protected $action;
    protected $defaultAction = 'index';
    protected $layout = 'main';
    protected $useLayout = true;

//    function __construct(App $app)
//    {
//        $this->app = $app;
//    }

    public function runAction() {
        $this->action = App::call()->request->getActionName() ?: $this->defaultAction;

        $method = "action" . ucfirst($this->action);
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            Die("Экшн не существует");
        }
    }

    public function render($template, $params = []) {
        if ($this->useLayout) {
            $session = App::call()->session;
            $userRepository = App::call()->usersRepository;
            $basketRepository = App::call()->basketRepository;
            return $this->renderTemplate("layouts/{$this->layout}", [
                'menu' =>  $this->renderTemplate('menu', [
                    'auth' => $userRepository->isAuth($session),
                    'username' => $userRepository->getLogin($session),
                    'countBasket' => $basketRepository->getCount($session->getId()),
                ]),
                'content' => $this->renderTemplate($template, $params)
            ]);
        } else {
            return $this->renderTemplate($template, $params);
        }
    }

    public function renderTemplate($template, $params = []) {
        return App::call()->render->renderTemplate($template, $params);
    }
}