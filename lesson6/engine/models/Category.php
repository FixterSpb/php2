<?php


namespace app\models;


class Category extends DBModel
{
    protected $id;
    protected $name;
    protected $status;

    protected $props =
        [
            'name' => false,
            'status' => false,
        ];


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