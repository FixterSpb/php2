<?php

namespace app\interfaces;

interface IModel
{
    static public function getOne($id);
    static public function getAll();
    public function insert();
    public function delete();

}