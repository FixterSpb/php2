<?php

namespace app\models;

use app\engine\App;
use app\engine\Db;
use app\interfaces\IModel;
use app\models\entities\Model;


abstract class Repository implements IModel
{
    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM `$tableName` WHERE `id` = :id";
        return App::call()->db->queryObject($sql, ["id" => $id], $this->getEntityClass());
    }

    public function getLimit($page) {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM `$tableName` LIMIT :page";
        return App::call()->db->queryLimit($sql, $page);
    }

    public function getAll() {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM $tableName";
        return App::call()->db->queryAll($sql);

    }

    public function getOneWhere($name, $value) {
        $tableName = $this->getTableName();

        $sql = "SELECT * FROM $tableName WHERE `$name`=:value";
        return App::call()->db->queryObject($sql, ['value' => $value], $this->getEntityClass());

    }

    public function getCountWhere($name, $value) {
        $tableName = $this->getTableName();
        $sql = "SELECT count(id) as count FROM $tableName WHERE `$name`=:value";

        return App::call()->db->queryOne($sql, ["value" => $value])['count'];
    }

    public static function getSumWhere($name) {
        //TODO SELECT SUM(price) FROM table WHERE $name = $value
    }

    protected function insert(Model $entity) {

        $params = [];
        $columns = [];

        foreach ($entity->props as $key => $value) {
            $params[":{$key}"] = $entity->$key;
            $columns[] = "`$key`";
        }

        $columns = implode(", ", $columns);
        $values = implode(", ", array_keys($params));

        $tableName = $this->getTableName();
        $sql = "INSERT INTO `{$tableName}`({$columns}) VALUES ($values)";
        App::call()->db->execute($sql, $params);
        $entity->id = App::call()->db->lastInsertId();
    }

    protected function update(Model $entity) {
        $params = [];
        $colums = [];
        foreach ($entity->props as $key => $value) {
            if (!$value) continue;
            $params[":{$key}"] = $entity->$key;
            $colums[] .= "`{$key}` = :{$key}";
        }
        $colums = implode(", ", $colums);
        $params[':id'] = $entity->id;
        $tableName = $this->getTableName();
        $sql = "UPDATE `{$tableName}` SET {$colums} WHERE `id` = :id";
        if(App::call()->db->execute($sql, $params)) {

            $entity->clearProps();
        }
    }



    public function delete(Model $entity) {
        $tableName = $this->getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id = :id";

        return App::call()->db->execute($sql, [':id' => $entity->id]);
    }

    public function save($entity) {
        if (is_null($entity->id)) {
            $this->insert($entity);
        } else {
            $this->update($entity);
        }
    }

    abstract protected function getEntityClass();
    abstract protected function getTableName();
}