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

        $userRepository = new UserRepository();


        if ($user = $userRepository->auth($login, $pass)) {
            $session = $this->app->getSession();
            if ($user->session_id) $session->setId($user->session_id);
            else {
                $user->session_id = $session->getId();
                $userRepository->save($user);
            }
            $session->login = $login;
            $session->role = $user->role;

            header('Location: ' . $request->getReferer());
        }else{
            die("Не верный логин/пароль.");
        }
    }

    public function actionLogout(){
        $session = $this->app->getSession();
        $session->regenerate();
        $session->destroy();
        header('Location: /');
        die;
    }
}