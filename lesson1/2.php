<?php

class Db
{
    private $query = "";

    public function table($tName)
    {
        $this->query = "SELECT * FROM `$tName` WHERE";
        return $this;
    }

    public function where($field, $value)
    {
        $this->query .= " `$field` = '$value'";
        return $this;
    }

    public function andWhere($field, $value)
    {
        $this->query .= " AND";
        return $this->where($field, $value);
    }

    public function get()
    {
        return $this->query . ';';
    }

    public function first($id)
    {
        return $this->query . " `id` = '$id';";
    }
};

$db = new Db;
echo "Вариант 1:<br>";
echo $db->table('user')->first(3);
echo '<br>';
echo $db->table('product')->where('name', 'Alex')->andWhere('sessinon', 123)->andWhere('id', 5)->get();
echo '<br>';
echo $db->table('user')->get();
echo '<br>';
echo '<br>';



class Db1
{
    //Немного доработанный вариант
    private $tableName = '';
    private $fields = '';
    private $where = '';
    private $values = [];

    public function table($tName, $fields = ['*'])
    {
        $this->clear();
        $this->tableName = $tName;
        //Вдруг имя поля совпадает с зарезервированным словом MySQL:
        $this->fields = implode(', ',
            array_map(function($el)
            {
                return "`$el`";
            },
            $fields));
        return $this;
    }

    public function where($field, $value)
    {
        if ($this->where === ""){
            $this->where = " WHERE";
        }
        $this->where .= " `$field` = '$value'";
        return $this;
    }

    public function andWhere($field, $value)
    {
        $this->where .= " AND";
        return $this->where($field, $value);
    }

    public function orWhere($field, $value)
    {
        $this->where .= "OR";
        return $this->where($field, $value);
    }

    private function clear(){
        $this->tableName = '';
        $this->fields = '';
        $this->where = '';
        $this->values = [];
    }

    public function get()
    {
        return "SELECT $this->fields FROM `$this->tableName`$this->where;";
    }

    public function insert(){

        return "INSERT INTO `" . $this->tableName . '` ( ' . implode(', ', array_keys($this->values)) . ') ' .
            "VALUES (" . implode(', ', $this->values) . ");";
    }

    public function value($field, $value){
        $this->values["`$field`"] = "'$value'";
        return $this;
    }


    public function first($id = null)
    {
        if (isset ($id))
        {
            return $this->where('id', $id)->get();
        }

        return $this->get();
    }
};

$db = new Db1();
echo "Вариант 2:<br>";
echo $db->table('user')->first(3);
echo '<br>';
echo $db->table('product')->where('name', 'Alex')->andWhere('sessinon', 123)->orWhere('id', 5)->get();
echo '<br>';
echo $db->table('user')->get();
echo '<br>';
echo $db->table('product', ['name', 'id'])->where('name', 'Alex')->andWhere('sessinon', 123)->orWhere('id', 5)->get();
echo '<br>';
echo $db->table('user')->get();

echo '<br>';
echo $db->table('user')->value('name', 'John')->value('session', 1534)->insert();