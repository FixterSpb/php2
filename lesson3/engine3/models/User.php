<?php

namespace app\models;


class User extends Model
{
    public $id;
    public $name;
    public $pass;


    public function __construct($name = null, $pass = null)
    {
        $this->name = $name;
        $this->pass = $pass;
    }


    protected function getTableName() {
        return "users";
    }

}