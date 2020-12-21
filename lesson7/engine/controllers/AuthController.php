<?php


namespace app\controllers;

use app\models\entities\User;
use app\models\repositories\UserRepository;

class AuthController extends Controller
{

    public function actionLogin(){
        $request = $this->app->getRequest();
        $params = $request->getParams();
        $login = array_get($params, 'login');
        $pass = array_get($params, 'password');


        if ($user = (new UserRepository())->auth($login, $pass)) {
            $session = $this->app->getSession();
            $session->login = $login;
            $session->role = $user->role;
            $session->setId($user>session_id);
            header('Location: ' . $request->getReferer());
        }else{
            die("Не верный логин/пароль.");
        }
    }

    public function actionLogout(){
        $session = $this->app->getSession();
        $session->regenerate();
        $session->destroy();
        header('Location: ' . $this->app->getRequest()->getReferer());
        die;
    }
}