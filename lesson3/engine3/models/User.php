<?php

namespace app\models;


class User extends Model
{
    public $name;
    public $pass;


    public function __construct($name = null, $pass = null)
    {
        $this->name = $name;
        $this->pass = $pass;
    }


    static protected function getTableName() {
        return "users";
    }

}