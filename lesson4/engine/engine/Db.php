<?php

namespace app\engine;

use app\traits\TSingletone;

final class Db
{
    protected $config = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'php2',
        'charset' => 'utf8'
    ];

    use TSingletone;

    protected $connection = null;

    protected function getConnection() {
        if (is_null($this->connection)) {
//            var_dump("Подключаюсь к БД!");
            $this->connection = new \PDO($this->prepareDsnString(),
                $this->config['login'],
                $this->config['password']);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }
        return $this->connection;
    }

    protected function prepareDsnString() {
        return sprintf("%s:host=%s;dbname=%s;charset=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset']
        );
    }

    protected function query($sql, $params) {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function queryLimit($sql, $page) {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':page', $page, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(); //TODO вернуть результат Execute
    }

    public function lastInsertId() {
        return $this->getConnection()->lastInsertId();
    }

    public function queryObject($sql, $params = [], $class) {
        $stmt = $this->query($sql, $params);
        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
//        $stmt->setFetchMode(\PDO::FETCH_INTO, $class);
        return $stmt->fetch();
    }

    public function queryObject_1($sql, $params = [], $class) {
        $stmt = $this->query($sql, $params);
//        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
        $stmt->setFetchMode(\PDO::FETCH_INTO, $class);
        return $stmt->fetch();
    }

    public function execute($sql, $params = []) {
        return $this->query($sql, $params)->rowCount();
    }

    public function queryOne($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    public function queryAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }


}