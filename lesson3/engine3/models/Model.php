<?php


namespace app\models;

use app\interfaces\IModel;
use app\engine\Db;

abstract class Model implements IModel
{
    public int $id;

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

    static public function getOne($id) {

        $sql = "SELECT * FROM `" . static::getTableName() . "` WHERE `id` = :id";
        return Db::getInstance()->queryObject($sql, ["id" => $id], static::class);

    }

    static public function getAll() {

        $sql = "SELECT * FROM " . static::getTableName();
        return Db::getInstance()->queryAll($sql);
    }

    public function insert() {

        $params = [];

        foreach ($this as $key => $value) {
            if ($key == 'id') continue;
                $params[$key] = $value;
        }

        $sql_fields = implode(', ', array_map(fn($item) => "`$item`", array_keys($params)));
        $sql_values =  implode(', ', array_map(fn($item) => ":$item", array_keys($params)));

        $sql = "INSERT INTO `{$this->getTableName()}` ($sql_fields) VALUES ($sql_values)";

        Db::getInstance()->execute($sql, $params);
        $this->id = Db::getInstance()->lastInsertId();

    }

    public function update() {

        $params = array_filter((array)$this, fn($key) => $key !== 'id', ARRAY_FILTER_USE_KEY);
        $new_values = implode(', ', array_map(fn($key) => "`$key` = :$key", array_keys($params)));
        $sql = "UPDATE `{$this->getTableName()}` SET $new_values WHERE `id` = :id";
        Db::getInstance()->execute($sql, (array)$this);
    }

    public function delete() {

        $sql = "DELETE FROM `{$this->getTableName()}` WHERE `id` = :id";
        var_dump($sql);
        Db::getInstance()->execute($sql, ['id' => $this->id]);
    }

    abstract static protected function getTableName();
}