<?php


namespace app\models;


class Categories extends Model
{
    public $id;
    public $name;
    public $status;

    /**
     * Categories constructor.
     * @param $name
     * @param $status
     */
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