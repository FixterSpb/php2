<?php


namespace app\engine;


class App
{
    protected $request;
    protected $session;
    protected $renderer = null;
    protected $defaultControllerName = 'product';

    public function __construct()
    {
        $this->request = new Request();
        $this->session = new Session();
    }

    public function getRender()
    {
        if (!$this->renderer) {
            $this->renderer = new TwigRender();
        }
        return $this->renderer;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }



    public function run(){

        $controllerName = $this->request->getControllerName() ?: $this->defaultControllerName;

        $controllerClass =  CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($this);
            $controller->runAction($this->request->getActionName());
        }
    }

}