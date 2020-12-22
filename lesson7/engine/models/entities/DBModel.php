<?php


namespace app\models;

use app\engine\Db;

abstract class DBModel extends Model
{

    public static function getOne($id) {
        $sql = "SELECT * FROM `" . static::getTableName() . "` WHERE `id` = :id";
        return Db::getInstance()->queryObject($sql, ["id" => $id], static::class);

    }

    public static function getLimit($page){
        $sql = "SELECT * FROM `" . static::getTableName() . "` LIMIT 0, :page";
        return Db::getInstance()->queryLimit($sql, $page);
    }

    public static function getAll() {

        $sql = "SELECT * FROM " . static::getTableName();
        return Db::getInstance()->queryAll($sql);
    }

    public static function getOneWhere($name, $value) {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `{$name}`=:value";
        return Db::getInstance()->queryObject($sql, ['value' => $value], static::class);
    }

    protected static function getCountWhere($name, $value){
        $tableName = static::getTableName();
        $sql = "SELECT count(id) as count FROM `{$tableName}` WHERE `{$name}` = :value";

        return Db::getInstance()->queryOne($sql, ['value' => $value])['count'];
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

        $params['id'] = $this->id;
        $sql = "UPDATE `{$this->getTableName()}` SET $new_values WHERE `id` = :id";

        if(Db::getInstance()->execute($sql, $params)) {

            foreach ($this->props as $key => $value) {
                $this->props[$key] = false;
            }
        }
    }

    public function delete() {

        $sql = "DELETE FROM `{$this->getTableName()}` WHERE `id` = :id";
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