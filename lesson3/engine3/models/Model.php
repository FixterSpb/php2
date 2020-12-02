<?php


namespace app\models;

use app\interfaces\IModel;
use app\engine\Db;

abstract class Model implements IModel
{


    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }


    public function getOne($id) {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        return Db::getInstance()->queryOne($sql, ["id" => $id]);
    }

    public function getObject($id) {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        Db::getInstance()->queryObject($sql, ["id" => $id], $this);
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->getTableName()}";
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

        var_dump($sql);
        Db::getInstance()->execute($sql, $params);
//        $this->id = Db::getInstance()->lastInsertId(); У CartItem и OrderItem нет id, поэтому:
        if(property_exists($this, 'id')){
            $this->id = Db::getInstance()->lastInsertId();
        }
    }

    public function update() {
        //У моделей cart_item и order_item нет id, однако все поля, заканчивающиеся на _id, составляют первичный ключ
        $whereParams = $this->getParams();

        echo "<pre>";
        var_dump($whereParams);

        var_dump(
        array_map(function($key){
            if (!isset($whereParams[$key])) {
//                continue;
                echo "<pre>";
                var_dump($key);
                echo "</pre>";
                return "`$key` = :$key";
            }
            return "`$key` = :$key";
        }, array_keys((array)$this)));

        print_r(array_keys((array)$this));
        echo "</pre>";

        $sql_where = implode(" AND ", array_map(fn($key) => "`$key` = :$key", array_keys($whereParams)));

        $new_values = implode(", ", array_map(function($key){
            if (!isset($whereParams[$key])) {
                echo "<pre>";
                var_dump($key);
                echo "</pre>";
                return "`$key` = :$key";
            }
            return;
        }, array_keys((array)$this)));

        $sql = "UPDATE `{$this->getTableName()}` SET $new_values WHERE $sql_where";
        echo "<pre>";
        var_dump($sql);
        echo "</pre>";
        die;
        Db::getInstance()->execute($sql, (array)$this);
    }

    public function delete() {

        //У моделей cart_item и order_item нет id, однако все поля, заканчивающиеся на _id, составляют первичный ключ
        $params = $this->getParams();

        $sql_params = implode(" AND ", array_map(fn($key) => "`$key` = :$key", array_keys($params)));

        $sql = "DELETE FROM `{$this->getTableName()}` WHERE $sql_params";
        Db::getInstance()->execute($sql, $params);
    }

    private function getParams(){

        $params = [];

        if (property_exists($this, 'id')){
            $params['id'] = $this->id;
        }else{
            $keys = preg_grep('/_id$/', array_keys((array)$this));
            foreach ($keys as $key => $item){
                $params[$item] = $this->$item;
            }
        }

        return $params;
    }


    abstract protected function getTableName();
}