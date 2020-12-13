<?php

namespace app\models;


class User extends DBModel
{
    protected $id;
    protected $name;
    protected $pass;
    protected $props =
        [
            'name' => false,
            'pass' => false,
        ];


    public function __construct($name = null, $pass = null)
    {
        $this->name = $name;
        $this->pass = $pass;
    }


    static protected function getTableName() {
        return "users";
    }

}