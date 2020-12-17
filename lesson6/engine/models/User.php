<?php

namespace app\models;


use app\engine\Session;

class User extends DBModel
{
    protected $id;
    protected $name;
    protected $login;
    protected $session_id;
    protected $role;
    protected $pass;

    protected $props =
        [
            'name' => false,
            'pass' => false,
            'login' => false,
            'session_id' => false,
            'role' => false,
        ];


    public function __construct($name = null, $pass = null)
    {
        $this->name = $name;
        $this->pass = $pass;
    }

    public static function auth($login, $pass) {
        $user = static::getOneWhere('login', $login);

        if (password_verify($pass, $user->pass)){
            return $user;
        }
    }

    public static function isAdmin(){
        return static::getRole() === 'admin';
    }

    protected static function getTableName() {
        return "users";
    }

    //Наверное, не логично сюда передавать session, но пока так
    public static function isAuth(Session $session) {
        return $session->getLogin() !== null;
    }

    public static function getRole(Session $session){
        return $session->getRole();
    }

    public static function getLogin(Session $session){
        return $session->getLogin();
    }
}