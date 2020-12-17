<?php


namespace app\controllers;

use app\interfaces\IRenderer;
use app\models\{User, Basket};
use app\engine\App;

class Controller
{
    protected $action;
    protected $defaultAction = 'index';
    protected $layout = 'main';
    protected $useLayout = true;
    protected $app;

    function __construct(App $app)
    {
        $this->app = $app;
    }

    public function runAction() {
        $this->action = $this->app->getRequest()->getActionName() ?: $this->defaultAction;

        $method = "action" . ucfirst($this->action);
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            Die("Экшн не существует");
        }
    }

    public function render($template, $params = []) {
        if ($this->useLayout) {
            $session = $this->app->getSession();
            return $this->renderTemplate("layouts/{$this->layout}", [
                'menu' =>  $this->renderTemplate('menu', [
                    'auth' => User::isAuth($session),
                    'username' => User::getLogin($session),
                    'countBasket' => Basket::getCount($session->getId()),
                ]),
                'content' => $this->renderTemplate($template, $params)
            ]);
        } else {
            return $this->renderTemplate($template, $params);
        }
    }

    public function renderTemplate($template, $params = []) {
        return $this->app->getRender()->renderTemplate($template, $params);
    }
}