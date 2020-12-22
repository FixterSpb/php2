<?php


namespace app\models\repositories;

use app\engine\App;
use app\models\Repository;
use app\engine\Session;
use app\models\entities\User;

class UserRepository extends Repository
{

    public function auth($login, $pass) {
        $user = App::call()->usersRepository->getOneWhere('login', $login);
        if (!$user) return;
        if (password_verify($pass, $user->pass)){
            return $user;
        }
    }

    public function isAdmin(){
        return $this->getRole() === 'admin';
    }

    //Наверное, не логично сюда передавать session, но пока так
    public function isAuth() {
        return App::call()->session->login !== null;
    }

    public function getRole(){
        return App::call()->session->role;
    }

    public function getLogin(){
        return App::call()->session->login;
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