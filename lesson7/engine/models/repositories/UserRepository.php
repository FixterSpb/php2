<?php


namespace app\models\repositories;

use app\models\Repository;
use app\engine\Session;
use app\models\entities\User;

class UserRepository extends Repository
{

    public function auth($login, $pass) {
        $user = $this->getOneWhere('login', $login);
//        dd($user);
        if (password_verify($pass, $user->pass)){
            return $user;
        }
    }

    public function isAdmin(){
        return $this->getRole() === 'admin';
    }

    //Наверное, не логично сюда передавать session, но пока так
    public function isAuth(Session $session) {
        return $session->login !== null;
    }

    public function getRole(Session $session){
        return $session->role;
    }

    public function getLogin(Session $session){
//        dd($_SESSION);
        return $session->login;
    }

    protected function getEntityClass()
    {
        return User::class;
    }

    protected function getTableName()
    {
        return 'users';
    }
}