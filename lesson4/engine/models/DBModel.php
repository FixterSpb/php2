<?php


namespace app\models;

use app\engine\Db;

abstract class DBModel extends Model
{
    protected $id;

    public function getOne($id) {
        $sql = "SELECT * FROM `" . static::getTableName() . "` WHERE `id` = :id";
        return Db::getInstance()->queryObject($sql, ["id" => $id], $this);

    }

    public static function getLimit($page){
        $sql = "SELECT * FROM `" . static::getTableName() . "`LIMIT 0, :page";
        return Db::getInstance()->queryObjecct($sql, ['page' => $page]);
    }

    public static function getAll() {

        $sql = "SELECT * FROM " . static::getTableName();
        return Db::getInstance()->queryAll($sql);
    }

    protected function insert() {

        $params = [];

        foreach ($this->props as $key => $value){
            $params[$key] = $this->$key;
        }

        $columns = implode(', ', array_map(fn($item) => "`$item`", array_keys($params)));
        $values =  implode(', ', array_map(fn($item) => ":$item", array_keys($params)));

        $sql = "INSERT INTO `" . static::getTableName() . "` ($columns) VALUES ($values)";

        Db::getInstance()->execute($sql, $params);
        $this->id = Db::getInstance()->lastInsertId();

    }

    protected function update() {

        $params = array_filter($this->props, fn($value) => $value);
        foreach ($params as $key => $value){
            $params[$key] = $this->$key;
        }

        $new_values = implode(', ', array_map(fn($key) => "`$key` = :$key", array_keys($params)));
        $sql = "UPDATE `" . static::getTableName() . "` SET $new_values WHERE `id` = $this->id";

//        $params['id'] = $this->id;
//        $sql = "UPDATE `{$this->getTableName()}` SET $new_values WHERE `id` = :id";

        Db::getInstance()->execute($sql, $params);

        foreach ($params as $key => $value){
//            if ($key === 'id') continue;
            $this->props[$key] = false;
        }

    }

    public function delete() {

        $sql = "DELETE FROM `{$this->getTableName()}` WHERE `id` = :id";
        var_dump($sql);
        Db::getInstance()->execute($sql, ['id' => $this->id]);
    }

    public function save(){
        if(!$this->id){
            $this->insert();
        }else{
            $this->update();
        }
    }
}