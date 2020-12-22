<?php

namespace app\models\entities;

class User extends Model
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

}