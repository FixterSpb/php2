<?php


namespace app\models;

use app\interfaces\IModel;
use app\engine\Db;

abstract class Model implements IModel
{

    public function __set($name, $value) {
        if ($name === 'id') return;

        $this->props[$name] = true;
        echo "<br>", $name, " => ", $value, "<br>";
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

    abstract static protected function getTableName();
}