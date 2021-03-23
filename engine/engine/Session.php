<?php


namespace app\engine;


class Session
{

    public function __get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function __set($name, $value){
        $_SESSION[$name] = $value;
    }

    public function __construct(){
        $this->start();
    }

    public function start(){
        session_start();
    }

    public function getId(){
        return session_id();
    }

    public function setId($id){
        $this->destroy();
        session_id($id);
        $this->start();

    }

    public function destroy(){
        session_destroy();
    }

    public function regenerate(){
        session_regenerate_id();
    }

}