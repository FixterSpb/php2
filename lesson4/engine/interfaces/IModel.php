<?php

namespace app\interfaces;

interface IModel
{
    public function getOne($id);
    static public function getAll();
    public function save();
//    public function insert();
//    protected function update();
    public function delete();

}