<?php


namespace app\models;


class Category extends DBModel
{
    protected $id;
    public $name;
    public $status;


    public function __construct($name = null, $status = 'active')
    {
        $this->name = $name;
        $this->status = $status;
    }

    static protected function getTableName()
    {
        return "categories";
    }




}