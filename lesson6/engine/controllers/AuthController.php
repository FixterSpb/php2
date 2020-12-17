<?php


namespace app\controllers;

use app\models\User;

class AuthController extends Controller
{

    public function actionLogin(){
        $request = $this->app->getRequest();
        $params = $request->getParams();
        $login = array_get($params, 'login');
        $pass = array_get($params, 'password');


        if ($user = User::auth($login, $pass)) {
            $session = $this->app->getSession();
            $session->setLogin($login);
            $session->setRole($user->role);
            header('Location: ' . $request->getReferer());
        }else{
            die("Не веный логин/пароль.");
        }
    }

    public function actionLogout(){
        session_destroy();
        header('Location: ' . $this->app->getRequest()->getReferer());
        die;
    }
}