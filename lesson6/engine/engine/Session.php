<?php


namespace app\engine;


class Session
{

    public function __construct(){
        $this->start();
    }

    public function start(){
        session_start();
    }

    public function getId(){
        return session_id();
    }

    public function setLogin($login){
        $_SESSION['login'] = $login;
    }

    public function getLogin(){
        return array_get($_SESSION, 'login');
    }

    public function setRole($role){
        $_SESSION['role'] = $role;
    }

    public function getRole(){
        return array_get($_SESSION, 'role');
    }


}