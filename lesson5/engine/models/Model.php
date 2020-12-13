<?php


namespace app\models;

use app\interfaces\IModel;
use app\engine\Db;

abstract class Model implements IModel
{

    public function __set($name, $value) {

        if (!property_exists($this, $name)) return;

        if(isset($this->props[$name])) $this->props[$name] = true;

        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    abstract static protected function getTableName();
}