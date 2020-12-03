<?php


namespace app\models;


class Category extends Model
{
    public $id;
    public $name;
    public $status;


    public function __construct($name = null, $status = 'active')
    {
        $this->name = $name;
        $this->status = $status;
    }

    protected function getTableName()
    {
        return "categories";
    }




}