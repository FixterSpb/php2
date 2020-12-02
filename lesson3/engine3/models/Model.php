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

//        var_dump($sql);
//        var_dump($params);
        Db::getInstance()->execute($sql, $params);
//      Первый вариант:
//        $this->id = Db::getInstance()->lastInsertId();
//      Но у CartItem и OrderItem нет поля id, поэтому:
        if(property_exists($this, 'id')){
            $this->id = Db::getInstance()->lastInsertId();
        }
    }

    public function update() {

        $whereParams = $this->getFieldsID();

        $new_values = '';
        $sql_where = '';

        foreach ($this as $key => $value) {

            if (isset($whereParams[$key])){

                if(strlen($sql_where)){
                    $sql_where .= ' AND ';
                }

                $sql_where .= "`$key` = :$key";
                continue;
            }

            if (strlen($new_values)){
                $new_values .= ', ';
            }
            $new_values .= "`$key` = :$key";
        }


        $sql = "UPDATE `{$this->getTableName()}` SET $new_values WHERE $sql_where";
//        var_dump($sql);
//        die;
        Db::getInstance()->execute($sql, (array)$this);
    }

    public function delete() {

        $params = $this->getFieldsID();

        $sql_params = implode(" AND ", array_map(fn($key) => "`$key` = :$key", array_keys($params)));

        $sql = "DELETE FROM `{$this->getTableName()}` WHERE $sql_params";
        Db::getInstance()->execute($sql, $params);
    }

    /**
     * Если существует поле id, возвращает массив ['id' => значение], иначе
     * возвращает массив с полями, заканчивающимися на "_id".
     * Пример: CartItem имеет поля product_id, cart_id, qty.
     * Метод вернет ['product_id' => значение, 'cart_id' => значение]
     *
     * @return array
     */
    private function getFieldsID(){

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