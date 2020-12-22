<?php


namespace app\controllers;

use app\engine\App;
use app\models\entities\User;
use app\models\repositories\UserRepository;

class AuthController extends Controller
{

    public function actionLogin(){
        $request = App::call()->request;
        $params = $request->getParams();
        $login = array_get($params, 'login');
        $pass = array_get($params, 'password');

        $userRepository = App::call()->usersRepository;


        if ($user = $userRepository->auth($login, $pass)) {
            $session = App::call()->session;
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
        $session = App::call()->session;
        $session->regenerate();
        $session->destroy();
        header('Location: /');
        die;
    }
}